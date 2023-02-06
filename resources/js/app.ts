/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import AppForm from './components/forms/app/AppForm.vue';
app.component('app-form', AppForm);

import DetectInfoForm from './components/forms/app/DetectInfoForm.vue';
app.component('detectinfo-form', DetectInfoForm);

import InstallerForm from './components/forms/app/InstallerForm.vue';
app.component('installer-form', InstallerForm);

import AppItem from './components/AppItem.vue';
app.component('app-item', AppItem);

app.mount('#app');
