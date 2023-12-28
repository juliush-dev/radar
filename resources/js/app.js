import "./bootstrap";
import "../css/app.css";
import "../css/tiptap.scss";
import "@protonemedia/laravel-splade/dist/style.css";
import "@protonemedia/laravel-splade/dist/style.css";
import "../css/choices.scss";
import "vue3-emoji-picker/css";
import Main from "./Components/Main.vue";
import Topic from "./Components/Topic.vue";
import Skill from "./Components/Skill.vue";
import Note from "./Components/Note.vue";
import BottomSide from "./Components/BottomSide.vue";
import LineChart from "./Components/LineChart.vue";
import TipTap from "./Components/TipTap.vue";
import.meta.glob(["../images/**", "../fonts/**"]);
import "@protonemedia/laravel-splade/dist/jodit.css";

import { createApp } from "vue/dist/vue.esm-bundler.js";
import { renderSpladeApp, SpladePlugin } from "@protonemedia/laravel-splade";

const el = document.getElementById("app");

createApp({
    render: renderSpladeApp({ el }),
})
    .use(SpladePlugin, {
        max_keep_alive: 10,
        view_transitions: true,
        transform_anchors: false,
        progress_bar: true,
        components: {
            Main,
            Topic,
            Skill,
            Note,
            LineChart,
            TipTap,
            BottomSide,
        },
    })
    .mount(el);
