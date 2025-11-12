<!-- MenuItem.vue -->
<template>
  <li>
    <router-link v-if="item.path" :to="item.path">{{ item.label }}</router-link>
    <span v-else>{{ item.label }}</span>
    <ul v-if="item.children && item.children.length">
      <MenuItem v-for="child in item.children" :key="child.label" :item="child" />
    </ul>
  </li>
</template>

<script>
export default {
  name: 'MenuItem',
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
/* Add your styling for menu items here */
ul {
  list-style: none;
  padding-left: 15px; /* For nested menus */
}
</style>