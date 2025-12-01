import { createRoot } from "react-dom/client";
import { App, InertiaAppProps } from "@inertiajs/inertia-react";
import { InertiaProgress } from "@inertiajs/progress";

const el = document.getElementById("app") as HTMLElement;

createRoot(el).render(
  <App
    initialPage={JSON.parse(el.dataset.page!)}
    resolveComponent={(name: string) =>
      import(`./Pages/${name}`).then((module) => module.default)
    }
  />
);

InertiaProgress.init();
