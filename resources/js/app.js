import "./bootstrap";
if ('serviceWorker' in navigator)
    {
        navigator.serviceWorker.register('/sw.js', { scope: '/' }).then(function (registration) {
            console.log(`SW registered successfully!`);
        }).catch(function (registrationError) {
            console.log(`SW registration failed`);
        });
    }
import "toastify-js/src/toastify.css";
import Toastify from "toastify-js";
window.Toastify = Toastify;
const flatpickr = require("flatpickr");

import "flatpickr/dist/flatpickr.css";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect";
import "flatpickr/dist/themes/dark.css";
import "flatpickr/dist/plugins/monthSelect/style.css";
import flatpickr from "flatpickr";
// flatpickr datepicker
flatpickr("#tanggal", {
    disableMobile: "true",
    dateFormat: "d-m-Y : H:i", //defaults to "F Y"
    enableTime: true,
});
flatpickr("#due_date", {
    disableMobile: "true",
    dateFormat: "d-m-Y ",
});
flatpickr("#completion_date", {
    disableMobile: "true",
    dateFormat: "d-m-Y ",
});
flatpickr("#tanggal_komplite", {
    disableMobile: "true",
    dateFormat: "d-m-Y",
});
flatpickr("#date_birth", {
    disableMobile: "true",
    dateFormat: "d-m-Y ", //defaults to "F Y"
});
flatpickr("#date_commenced", {
    disableMobile: "true",
    dateFormat: "d-m-Y ", //defaults to "F Y"
});
flatpickr("#end_date", {
    disableMobile: "true",
    dateFormat: "d-m-Y ", //defaults to "F Y"
});
flatpickr("#month", {
    disableMobile: "true",
    plugins: [
        new monthSelectPlugin({
            shorthand: true, //defaults to false
            dateFormat: "M-Y", //defaults to "F Y"
            altFormat: "F Y", //defaults to "F Y"
            theme: "dark", // defaults to "light"
        }),
    ],
});


// code for resposive side-bar menu

// start: Sidebar
const sidebarToggle = document.querySelector(".sidebar-toggle");
const sidebarOverlay = document.querySelector(".sidebar-overlay");
const sidebarMenu = document.querySelector(".sidebar-menu");
const main = document.querySelector(".main");

if (window.innerWidth < 768) {
    main.classList.toggle("active");
    sidebarOverlay.classList.toggle("hidden");
    sidebarMenu.classList.toggle("-translate-x-full");
}
sidebarToggle.addEventListener("click", function (e) {
    e.preventDefault();
    main.classList.toggle("active");
    sidebarOverlay.classList.toggle("hidden");
    sidebarMenu.classList.toggle("-translate-x-full");
});
sidebarOverlay.addEventListener("click", function (e) {
    e.preventDefault();
    main.classList.add("active");
    sidebarOverlay.classList.add("hidden");
    sidebarMenu.classList.add("-translate-x-full");
});
document.querySelectorAll(".sidebar-dropdown-toggle").forEach(function (item) {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        const parent = item.closest(".group");
        if (parent.classList.contains("selected")) {
            parent.classList.remove("selected");
        } else {
            document
                .querySelectorAll(".sidebar-dropdown-toggle")
                .forEach(function (i) {
                    i.closest(".group").classList.remove("selected");
                });
            parent.classList.add("selected");
        }
    });
});
// end: Sidebar
// star:chart
