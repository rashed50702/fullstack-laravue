<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1>I will show how other components react to changes</h1>
                <h2>Master Component current state of counter is: {{ counter }}</h2>

                <div>
                    <comA></comA>
                </div>
                <div>
                    <comB></comB>
                </div>
                <div>
                    <comC></comC>
                </div>

                <Button type="info" @click="changeCounter">Change the state of counter</Button>
            </div>
        </div>
    </div>
</template>
<script>
import comA from './comA.vue'
import comB from './comB.vue'
import comC from './comC.vue'

import { mapGetters } from 'vuex'

export default{
    data(){
        return{
            localVar: 5
        }
    },
    computed:{
        ...mapGetters({
            'counter': 'getCounter'
        })
    },

    methods:{
        changeCounter(){
            // this.$store.commit('changeTheCounter', 1);
            this.$store.dispatch('changeCounterAction', 1);
        },
        runSomething(){
            console.log("run sommething");
        }
    },
    components:{
        comA,
        comB,
        comC,
    },
    watch:{
        counter(value){

            console.log('counter is changing ', value);
            this.runSomething();
            console.log('localvar---', this.localVar);
        }
    }
}
</script>