<template>
    <div>
        <div v-if="$store.state.user">
            <!--========== ADMIN SIDE MENU ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <div v-for="(menuItem, i) in permissions" :key="i" v-if="permissions.length">
                                <li v-if="menuItem.read">
                                    <router-link :to="menuItem.name">
                                        <Icon :type='menuItem.iconType' /> {{ menuItem.resourceName}}
                                    </router-link>
                                </li>
                            </div>
                            <li>
                                <a href="/logout">
                                    <Icon type="ios-power" />Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                            <li>
                                <Icon type="ios-albums" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    props: ['user', 'permissions'],
    data() {
        return {
            isLoggedIn: false,
        }
    },

    created() {
        this.$store.commit('setUpdateUser', this.user);
        this.$store.commit('setUserPermission', this.permissions);
        // console.log(this.permissions);
    }
}
</script>
