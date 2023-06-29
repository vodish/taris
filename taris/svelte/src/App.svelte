<script>

import router from 'page';
import Login from "./Login.svelte";
import List from "./List.svelte";


// компонент
let component;

function setComponent() {
    
}

// роутер
router('/',      ctx => component = Login )
router('/*',     ctx => component = List )
router.start();


</script>


<svelte:component this="{component}" />
