import { createRouter, createWebHistory } from 'vue-router';
import CardPage from '@/Components/App.vue';

const routes = [
    { path: '', component: CardPage },
    { path: '/cards/:id', component: CardPage, props: true }, // Allows viewing existing cards
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
