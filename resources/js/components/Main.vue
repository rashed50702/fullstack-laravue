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
                        <!-- <Menu :open-names="['1']" accordion>
                            <Submenu name="1">
                                <template #title>
                                    <Icon type="ios-paper" />
                                    内容管理
                                </template>
                                <MenuItem name="1-1">文章管理</MenuItem>
                                <MenuItem name="1-2">评论管理</MenuItem>
                                <MenuItem name="1-3">举报管理</MenuItem>
                            </Submenu>
                            <Submenu name="2">
                                <template #title>
                                    <Icon type="ios-people" />
                                    用户管理
                                </template>
                                <MenuItem name="2-1">新增用户</MenuItem>
                                <MenuItem name="2-2">活跃用户</MenuItem>
                            </Submenu>
                            <Submenu name="3">
                                <template #title>
                                    <Icon type="ios-stats" />
                                    统计分析
                                </template>
                                <MenuGroup title="使用">
                                    <MenuItem name="3-1">新增和启动</MenuItem>
                                    <MenuItem name="3-2">活跃分析</MenuItem>
                                    <MenuItem name="3-3">时段分析</MenuItem>
                                </MenuGroup>
                                <MenuGroup title="留存">
                                    <MenuItem name="3-4">用户留存</MenuItem>
                                    <MenuItem name="3-5">流失用户</MenuItem>
                                </MenuGroup>
                            </Submenu>
                        </Menu> -->
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
