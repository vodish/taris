// @ts-nocheck
import './app.css'
import App  from './App.svelte'

console.log(document.body.dataset.key)

const app = new App({
    target: document.getElementById('app'),
})

export default app
