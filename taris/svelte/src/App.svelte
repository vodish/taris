<script>
  import router from 'page';
  import Login from "./Login.svelte";
  import Page from "./Page.svelte";
  
  
  // компонент
  let component

  // роутер
  router('/',      ctx => component = Login )
  router('/*',     ctx => component = Page  )
  router.start();

</script>

<svelte:component this="{component}" />
