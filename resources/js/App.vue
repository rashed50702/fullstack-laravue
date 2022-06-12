<template>
    <div class="container">
        <div id="nav">
            <router-link to="/home">Home</router-link> |
            <router-link to="/about">About</router-link>
        </div>
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Main App</span>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {}
</script>
