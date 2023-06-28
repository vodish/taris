<script>
  import router from 'page';
  import Login from "./Login.svelte";
  import Page from "./Page.svelte";
  
  
  // компонент
  let component;

  // роутер
  router('/',      () => component = Login)
  router('/*',     () => component = Page)
  router.start();
</script>


<svelte:component this="{component}" />
