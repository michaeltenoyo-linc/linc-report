import { AdminItems } from "./pages/AdminItems";
import { AdminTrucks } from "./pages/AdminTrucks";
import { AdminSjalan } from "./pages/AdminSjalan";
import { ItemsModal } from "./modals/ItemsModal";
import { AdminReport } from "./pages/AdminReport";

export const load = () => {
    AdminItems();
    AdminTrucks();
    AdminSjalan();
    ItemsModal();
    AdminReport();
};

load();
