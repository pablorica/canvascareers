# Canvas Careers — PHP Security Update (October 2026)

**Date:** 29 October 2026  
**Website:** https://canvas-careers.com/  
**Server:** `canvas-careers-wordpress-ubuntu` (DigitalOcean Droplet)  
**Server OS:** Ubuntu 24.04.4 LTS  
**Stack:** WordPress, Apache 2.4, PHP 8.3 via Apache `mod_php` (not PHP-FPM)  
**Status:** PHP update completed; WordPress functional checks passed. Separate kernel maintenance pending.

## 1. Reason for update

Review and remediate the PHP security vulnerabilities reported in October 2026:

- CVE-2026-109618
- CVE-2026-109619

The server had PHP **8.3.31** installed from the Ondřej Surý PHP PPA. The same configured repository offered **PHP 8.3.36**, the patched target for this PHP branch.

## 2. Initial environment and package assessment

The following checks established the installed runtime, package source, and available upgrades:

```bash
php -v
apache2ctl -M | grep -i php
apt-cache policy php8.3-fpm php8.3-cli php8.3-common libapache2-mod-php8.3
apt list --upgradable 2>/dev/null | grep -E '^php|^libapache2-mod-php'
grep -RhE '^[^#].*(ondrej|sury)' /etc/apt/sources.list /etc/apt/sources.list.d/ 2>/dev/null
```

Findings:

- CLI PHP version: **8.3.31**.
- `php_module (shared)` was loaded in Apache.
- `libapache2-mod-php8.3`, `php8.3-cli`, and `php8.3-common` were installed at `8.3.31-3+ubuntu24.04.1+deb.sury.org+1`.
- `php8.3-fpm` was **not installed**.
- Candidate version for installed PHP 8.3 packages: `8.3.36-1+ubuntu24.04.1+deb.sury.org+1` from `https://ppa.launchpadcontent.net/ondrej/php/ubuntu/`.
- This was an in-place PHP **8.3 patch update**, not a PHP major/minor version migration.

## 3. Dry-run / change impact

Executed a non-destructive simulation:

```bash
sudo apt-get -s install --only-upgrade 'php8.3*' libapache2-mod-php8.3
```

APT reported:

```text
19 upgraded, 0 newly installed, 0 to remove and 56 not upgraded.
```

All 19 selected installed PHP packages were to move from PHP 8.3.31 to 8.3.36. The messages about skipping uninstalled optional PHP extensions were expected. No package removals were planned. The 56 other packages were outside this targeted PHP upgrade.

**Operational precaution:** A DigitalOcean snapshot and current WordPress database backup were recommended before the production change. Their actual creation was not confirmed in the conversation; do not record them as completed without checking.

## 4. PHP package update

Executed:

```bash
sudo apt-get install --only-upgrade 'php8.3*' libapache2-mod-php8.3
```

This updated the Apache PHP module, CLI runtime, core libraries and installed extensions, including MySQL, cURL, GD, GMP, intl, mbstring, OPcache, XML, ZIP, SOAP, tidy and others.

The package process reported a **pending kernel upgrade** (details in section 9). It also deferred restarting some unrelated services; it reported no containers needing restart.

### Post-installation package verification

```bash
php -v
dpkg-query -W libapache2-mod-php8.3 php8.3-cli php8.3-common
```

Observed:

```text
PHP 8.3.36 (cli) (built: Oct 21 2026 14:32:55) (NTS)

libapache2-mod-php8.3  8.3.36-1+ubuntu24.04.1+deb.sury.org+1
php8.3-cli             8.3.36-1+ubuntu24.04.1+deb.sury.org+1
php8.3-common          8.3.36-1+ubuntu24.04.1+deb.sury.org+1
```

**Result:** The relevant installed PHP runtime and Apache PHP module packages were successfully upgraded to PHP 8.3.36.

## 5. Apache validation and restart

Checks performed:

```bash
sudo apache2ctl configtest
sudo systemctl status apache2 --no-pager
sudo journalctl -u apache2 -n 50 --no-pager
sudo phpquery -v 8.3 -s apache2 -M
```

Findings:

- `apache2ctl configtest` returned **`Syntax OK`**.
- `apache2.service` was **active (running)** following the upgrade.
- Apache restarted successfully at **13:02:41 UTC** on 29 October 2026; subsequent logs also showed normal Apache starts.
- `phpquery` showed expected enabled Apache PHP extensions, including `mysqli`, `pdo_mysql`, `curl`, `gd`, `mbstring`, `opcache`, `intl`, and XML modules.
- Apache emitted `AH00558` because no global `ServerName` was configured; this was an existing non-fatal warning, not a PHP security failure.
- During one restart, systemd forcibly terminated three remaining Apache worker processes before the service restarted. The service subsequently returned to running status.

## 6. Additional session upload-progress mitigation

The initial CLI check showed PHP's session upload-progress feature enabled:

```bash
php -i | grep 'session.upload_progress'
```

Relevant initial output:

```text
session.upload_progress.enabled => On => On
```

A separate Apache PHP configuration override was added:

**File:** `/etc/php/8.3/apache2/conf.d/99-disable-upload-progress.ini`

```ini
; Security mitigation: disable PHP session upload progress
session.upload_progress.enabled = Off
```

The file was subsequently inspected and its contents confirmed. A search for related settings found the new active override and only **commented-out** examples in the Apache `php.ini`; no conflicting active file-based directive was found:

```bash
cat /etc/php/8.3/apache2/conf.d/99-disable-upload-progress.ini
sudo grep -Rni 'session.upload_progress' \
  /etc/php/8.3/apache2/ \
  /etc/apache2/ 2>/dev/null
```

Apache configuration validation continued to return `Syntax OK`, and later logs showed normal Apache restarts.

**Verification nuance:** This command was also run:

```bash
php -c /etc/php/8.3/apache2/php.ini \
  -d session.upload_progress.enabled=Off \
  -i | grep 'session.upload_progress.enabled'
```

It returned `Off => Off`, **but this is not independent verification** because the `-d` flag explicitly forces the value. A definitive effective-setting check through Apache's actual web runtime was not captured. The Apache config file and lack of conflicting file-based directives were confirmed.

A more useful non-forced local configuration check, if needed, is:

```bash
PHP_INI_SCAN_DIR=/etc/php/8.3/apache2/conf.d \
php -c /etc/php/8.3/apache2/php.ini -i \
  | grep 'session.upload_progress.enabled'
```

This still tests CLI parsing of Apache's configuration, rather than an actual Apache-served PHP request.

## 7. Apache error log review

Inspected:

```bash
sudo tail -n 60 /var/log/apache2/error.log
```

Observed:

- Multiple `AH01276` entries for attempts to browse WordPress directories. Apache denied directory listing as configured.
- `AH10244` entries for malformed `/cgi-bin/.../bin/sh` traversal-style requests. Apache rejected the invalid URI paths. These indicate suspicious scanning attempts, **not proof of compromise**.
- `AH00163` entries indicating Apache resumed normal operation after restarts.
- `sh: 1: gs: not found` appeared; some process tried to invoke Ghostscript. The source and functional impact were not established. Investigate separately if PDF/image processing has issues.
- No PHP fatal error attributable to the PHP upgrade was apparent in the supplied log excerpt. This is not a complete security or application-log audit.

## 8. WordPress functionality verification

After the update, the website owner/developer confirmed that **all WordPress checks were performed and everything was running fine**.

Checks discussed included:

- Frontend homepage and important pages.
- WordPress admin and content editing.
- Media Library uploads.
- Contact forms and important site functionality.
- WordPress Site Health runtime version.

The final confirmation reported that all WordPress checks passed; individual screenshots and test logs were not retained here.

## 9. Remaining / separate maintenance

### Pending kernel reboot

The PHP package update displayed:

```text
Pending kernel upgrade!
Running kernel version: 6.8.0-142-generic
Expected kernel version: 6.8.0-147-generic
```

The kernel update is **separate from the PHP CVE remediation**. Schedule a controlled reboot with a verified snapshot/backup and maintenance window, then check:

```bash
uname -r
sudo systemctl status apache2 --no-pager
```

### Additional observations

- The systemd history showed substantial Apache memory/swap peaks on the small Droplet; monitor resource pressure separately.
- The missing `gs` executable can be investigated if a PDF/image workflow is affected.
- If a complete audit is required, inspect other services/containers and confirm no other public PHP runtimes are exposed. Previous process listings included `apache2 -DFOREGROUND` processes, whose origin was not resolved in this record.
- Optionally verify the effective upload-progress directive through a safely restricted Apache-served diagnostic; remove any temporary diagnostic immediately after testing.

## 10. Outcome

**PHP security remediation: completed on 29 October 2026.**

- PHP 8.3.31 updated to **8.3.36**.
- Apache `mod_php` updated to the same patched version.
- Apache configuration validated and service restarted successfully.
- An additional Apache PHP upload-progress mitigation was configured.
- WordPress functionality checked successfully after the change.
- Kernel reboot and other operational observations tracked separately.

The PHP 8.3.36 package update addresses **CVE-2026-109618** and **CVE-2026-109619** at the installed package level. This record does not claim that the entire server is free of other vulnerabilities.
