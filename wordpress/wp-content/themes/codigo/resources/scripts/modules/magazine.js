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
      // The theme makes #main the scroll container on desktop (#app is locked
      // to 100dvh, #main is overflow-y:auto), so ScrollTrigger must watch #main
      // rather than the window — otherwise the pin never receives any scroll.
      const scroller = document.querySelector("#main") || undefined;

      const distance = () => Math.max(0, track.scrollWidth - window.innerWidth);

      const pages = () => section.querySelectorAll(".magazine__page");

      // Snap to page/spread boundaries expressed as a fraction of total scroll.
      const snapTo = (value) => {
        const total = distance();
        const first = pages()[0];
        if (!total || !first) return value;

        const pageWidth = first.getBoundingClientRect().width;
        const step = (pageWidth * pagesPerSnap) / total;
        if (!isFinite(step) || step <= 0) return value;

        return Math.min(1, Math.round(value / step) * step);
      };

      const tween = gsap.to(track, {
        x: () => -distance(),
        ease: "none",
      });

      const st = ScrollTrigger.create({
        animation: tween,
        trigger: section,
        scroller,
        start: "top top",
        end: () => "+=" + distance(),
        pin: true,
        pinType: "transform", // element scroller → pin via transform, not fixed
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
