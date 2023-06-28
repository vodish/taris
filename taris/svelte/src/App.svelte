<script>
  import router from 'page';
  import Login from "./Login.svelte";
  import Page from "./Page.svelte";
  
  
  // компонент
  let component;

  // роутер
  router('/',      () => component = Login)
  router('/*',     () => {
    console.log( new Date().getTime() )
    component = Page
  })
  router.start();

  // let time = new Date().getTime();
  // console.log(time)

</script>


<svelte:component this="{component}" />
