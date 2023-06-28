<script>
  import router from 'page';
  import Login from "./Login.svelte";
  import Page from "./Page.svelte";
  
  
  // компонент
  let component
  let ctx = {};

  // роутер
  router('/',      context => component = Login)
  router('/*',     context => {
    ctx = context
    component = Page
  })
  router.start();

  // let time = new Date().getTime();
  // console.log(time)

</script>

{#key ctx}
  <svelte:component this="{component}" />
{/key}

