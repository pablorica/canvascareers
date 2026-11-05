/**
 * Magazine — horizontal, magazine-style scroll.
 *
 * Desktop (>=1024px): pins each [data-magazine] section and translates its
 * track horizontally as the reader scrolls, snapping to page (or spread)
 * boundaries. Below 1024px it does nothing — the track stacks vertically via
 * CSS, giving a normal vertical read on mobile.
 *
 * Relies on gsap (already a dependency) + the ScrollTrigger plugin.
 */
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const magazine = () => {
  const sections = document.querySelectorAll("[data-magazine]");
  if (!sections.length) return;

  sections.forEach((section) => {
    const track = section.querySelector("[data-magazine-track]");
    if (!track) return;

    // "page" = advance one page at a time; "spread" = two pages at a time.
    const pagesPerSnap = section.dataset.snap === "spread" ? 2 : 1;

    const mm = gsap.matchMedia();

    mm.add("(min-width: 1024px)", () => {
      // The window is the scroller: magazine.scss releases #app/#main from the
      // theme's app-shell scrolling on collaborator pages. With the default
      // scroller, ScrollTrigger pins with position: fixed, which doesn't jitter
      // in Chrome the way a transform pin inside #main did.

      const distance = () => Math.max(0, track.scrollWidth - window.innerWidth);

      const pages = () => section.querySelectorAll(".magazine__page");

      // Rest points, in pixels of travel: every page's left edge, plus the point
      // where each text page's right edge meets the window. Pages don't fit the
      // window exactly, so without these a text page can only rest cut off.
      const stops = () => {
        const total = distance();
        const trackLeft = track.getBoundingClientRect().left;
        const lefts = [];
        const rights = [];

        pages().forEach((page, index) => {
          const { left, width } = page.getBoundingClientRect();
          const start = left - trackLeft;

          if (index % pagesPerSnap === 0) lefts.push(start);
          if (page.matches(".magazine__page--text")) {
            rights.push(start + width - window.innerWidth);
          }
        });

        // A left-edge stop just short of a right-edge one would clip that text
        const margin = (pages()[0]?.getBoundingClientRect().width ?? 0) / 4;
        const clear = lefts.filter(
          (left) => !rights.some((right) => Math.abs(right - left) < margin)
        );

        return [0, total, ...clear, ...rights].filter(
          (point) => point >= 0 && point <= total
        );
      };

      const snapTo = (value) => {
        const total = distance();
        if (!total) return value;

        const position = value * total;
        const nearest = stops().reduce((best, point) =>
          Math.abs(point - position) < Math.abs(best - position) ? point : best
        );

        return nearest / total;
      };

      const tween = gsap.to(track, {
        x: () => -distance(),
        ease: "none",
      });

      const st = ScrollTrigger.create({
        animation: tween,
        trigger: section,
        start: "top top",
        end: () => "+=" + distance(),
        pin: true,
        scrub: 1,
        invalidateOnRefresh: true,
        snap: {
          snapTo,
          duration: { min: 0.2, max: 0.5 },
          ease: "power1.inOut",
        },
      });

      // Teardown when leaving the desktop breakpoint.
      return () => {
        st.kill();
        gsap.set(track, { clearProps: "transform" });
      };
    });
  });

  // Images finishing after first paint can change the track width.
  window.addEventListener("load", () => ScrollTrigger.refresh());
};

export default magazine;