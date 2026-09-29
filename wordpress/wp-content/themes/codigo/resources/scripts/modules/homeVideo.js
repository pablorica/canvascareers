/**
 * Homepage collaborator video
 *
 * - Tries to autoplay muted (the only way browsers allow autoplay)
 * - Shows a large centred play button if autoplay is blocked (iOS Low Power
 *   Mode, browser settings, data saver) or if the visitor prefers reduced motion
 * - Play/pause and sound toggles in the bottom-right corner
 */
export default function homeVideo() {
  document.querySelectorAll('[data-home-video]').forEach(initVideo);
}

function initVideo(root) {
  const video = root.querySelector('video');
  if (!video) return;

  const playButton = root.querySelector('[data-video-play]');
  const toggleButton = root.querySelector('[data-video-toggle]');
  const soundButton = root.querySelector('[data-video-sound]');
  const iconPlay = toggleButton?.querySelector('[data-icon-play]');
  const iconPause = toggleButton?.querySelector('[data-icon-pause]');
  const iconMuted = soundButton?.querySelector('[data-icon-muted]');
  const iconSound = soundButton?.querySelector('[data-icon-sound]');

  // The large centred button is only for "the video hasn't been able to start".
  // Once it has played, pausing is handled by the small toggle instead.
  let hasStarted = false;

  // Set the properties as well as the attribute: some Safari versions only
  // honour the property when deciding whether autoplay is allowed.
  video.muted = true;
  video.defaultMuted = true;

  const showPlay = () => playButton?.classList.remove('hidden');
  const hidePlay = () => playButton?.classList.add('hidden');

  const tryPlay = () => {
    const attempt = video.play();
    if (attempt && typeof attempt.then === 'function') {
      attempt.catch(() => {
        if (!hasStarted) showPlay();
        syncPlayback();
      });
    }
  };

  const syncPlayback = () => {
    if (!toggleButton) return;
    const paused = video.paused;
    toggleButton.setAttribute('aria-label', paused ? 'Play video' : 'Pause video');
    iconPlay?.classList.toggle('hidden', !paused);
    iconPause?.classList.toggle('hidden', paused);
  };

  const syncSound = () => {
    if (!soundButton) return;
    const muted = video.muted;
    soundButton.setAttribute('aria-pressed', String(!muted));
    soundButton.setAttribute('aria-label', muted ? 'Turn sound on' : 'Turn sound off');
    iconMuted?.classList.toggle('hidden', !muted);
    iconSound?.classList.toggle('hidden', muted);
  };

  video.addEventListener('play', () => {
    hasStarted = true;
    hidePlay();
    syncPlayback();
  });
  video.addEventListener('pause', syncPlayback);
  video.addEventListener('volumechange', syncSound);

  playButton?.addEventListener('click', tryPlay);

  toggleButton?.addEventListener('click', () => {
    if (video.paused) {
      tryPlay();
    } else {
      video.pause();
    }
  });

  soundButton?.addEventListener('click', () => {
    video.muted = !video.muted;
    // Clicking is a user gesture, so playback with sound is allowed here
    if (video.paused) tryPlay();
  });

  syncPlayback();
  syncSound();

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReducedMotion) {
    showPlay();
    return;
  }

  tryPlay();
}