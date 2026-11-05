/**
 * Magazine menu — opens from a hover zone on the left edge of magazine articles.
 *
 * Mouse: opens on hover and closes shortly after the pointer leaves.
 * Keyboard: opens when a link takes focus, closes with Escape or on tabbing out.
 * Touch: tap the left edge to open, tap outside to close.
 *
 * The slide itself is a CSS transition (see magazine-menu.scss).
 */
const CLOSE_DELAY = 150;

const magazineMenu = () => {
  const menu = document.querySelector("[data-magazine-menu]");
  if (!menu) return;

  const zone = menu.querySelector("[data-magazine-menu-zone]");
  let closeTimer;

  const setOpen = (open) => {
    clearTimeout(closeTimer);
    menu.classList.toggle("is-open", open);
  };

  menu.addEventListener("pointerenter", (event) => {
    if (event.pointerType === "mouse") setOpen(true);
  });

  menu.addEventListener("pointerleave", (event) => {
    if (event.pointerType !== "mouse" || menu.contains(document.activeElement)) return;
    closeTimer = setTimeout(() => setOpen(false), CLOSE_DELAY);
  });

  zone?.addEventListener("click", () => setOpen(true));

  menu.addEventListener("focusin", () => setOpen(true));

  menu.addEventListener("focusout", (event) => {
    if (!menu.contains(event.relatedTarget)) setOpen(false);
  });

  document.addEventListener("pointerdown", (event) => {
    if (!menu.contains(event.target)) setOpen(false);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key !== "Escape" || !menu.classList.contains("is-open")) return;
    document.activeElement?.blur();
    setOpen(false);
  });
};

export default magazineMenu;
