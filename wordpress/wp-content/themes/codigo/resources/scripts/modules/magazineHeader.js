/**
 * Magazine header — below the desktop breakpoint the site header slides up out
 * of view as the reader scrolls down an article, and back down when they scroll
 * up. The slide itself is a CSS transition (see magazine.scss).
 */
const SCROLL_TOLERANCE = 8;

const magazineHeader = () => {
  const header = document.getElementById("mainMenu");
  if (!header || !document.body.classList.contains("display-magazine")) return;

  const mobile = window.matchMedia("(max-width: 1023px)");
  let lastY = window.scrollY;

  const setHidden = (hidden) => header.classList.toggle("is-slid-up", hidden);

  window.addEventListener(
    "scroll",
    () => {
      const y = Math.max(0, window.scrollY);

      // The open mobile menu lives inside the header, so it must stay visible
      if (!mobile.matches || document.body.classList.contains("overflow-hidden")) {
        setHidden(false);
        lastY = y;
        return;
      }

      if (Math.abs(y - lastY) < SCROLL_TOLERANCE) return;

      setHidden(y > lastY && y > header.offsetHeight);
      lastY = y;
    },
    { passive: true }
  );
};

export default magazineHeader;
