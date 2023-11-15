import "./bootstrap";
import "../css/app.css";
import "@protonemedia/laravel-splade/dist/style.css";
import "@protonemedia/laravel-splade/dist/style.css";
import "../css/choices.scss";
import "vue3-emoji-picker/css";
import Topic from "./Components/Topic.vue";
import Skill from "./Components/Skill.vue";
import Checkpoint from "./Components/Checkpoint.vue";
import CheckpointSession from "./Components/CheckpointSession.vue";
import QuestionsCube from "./Components/QuestionsCube.vue";
import Question from "./Components/Question.vue";
import Countdown from "./Components/Countdown.vue";
import LineChart from "./Components/LineChart.vue";

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
            Topic,
            Skill,
            Checkpoint,
            CheckpointSession,
            QuestionsCube,
            Question,
            LineChart,
            Countdown,
        },
    })
    .mount(el);
