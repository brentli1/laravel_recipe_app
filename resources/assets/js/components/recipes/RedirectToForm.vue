<template>
  <div></div>
</template>

<script>
// This is needed temporarily to force rerender of form when
// navigating from edit to add new recipe. 
export default {
    created() {
        this.$router.push('/recipe/new');
    }
}
</script>
