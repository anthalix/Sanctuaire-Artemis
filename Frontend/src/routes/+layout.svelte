<script>
  import Header from '../lib/Header.svelte';
  import Footer from '../lib/Footer.svelte';
 
  import  '../app.css';
</script>

<Header />

<!-- Ceci est la place où les pages spécifiques s’inséreront -->
<slot />

<Footer/>


