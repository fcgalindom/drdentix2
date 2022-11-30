<template>
        <div class="container" v-if="users.per_page < users.total">
            <div class="row text-center">
                 <!-- <div class="col-12 col-sm-4 text-sm-start my-4"> -->
                     <!-- <span>Viendo {{ users.to }} registro de {{ users.total }}</span> -->
                    <!-- <button type="button" class="btn btn-lg btn-pink rounded-pill shadow-none" v-if="users.current_page > 1" @click="changePages(users.current_page - 1)"><b>Anterior</b></button> -->
                <!-- </div> -->
                <div class="col-12 col-md-4 my-2 d-flex justify-content-center">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-left-radius" v-if="users.current_page > 1">
                            <button class="btn btn-tranparent btn-sm shadow-none" @click="changePages(users.current_page - 1)"><i class="fas fa-chevron-left fa-xs"></i></button>
                        </li>
                        <li class="list-group-item" v-for="(i,index) in pageNumber" :key="index" v-bind:class="[i == isActive ? ' current text-white': '']"> <span>{{ i }}</span> </li>
                        <li class="list-group-item border-right-radius" v-if="users.current_page < users.last_page">
                            <button class="btn btn-transparent btn-sm shadow-none" @click="changePages(users.current_page + 1)">
                                <i class="fas fa-chevron-right fa-xs"></i>
                            </button>
                        </li>
                    </ul>
                </div>
                 <div class="col-12 col-md-8 text-sm-end my-3 text-gray">
                     <span>Viendo del registro {{ users.to - users.per_page }} hasta el {{ users.to }} de un total de {{ users.total }} registros</span>
                     <!-- <span>Total: {{ users.total }}</span> -->
                    <!-- <button type="button" class="btn btn-lg btn-pink rounded-pill shadow-none" v-if="users.current_page < users.last_page" @click="changePages(users.current_page + 1)"><b>Siguiente</b></button> -->
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        props:["users"],
        data() {
            return {
                offset: 2,
            };
        },
        methods: {
            changePages(page) {
                this.users.current_page = page;
                this.$emit("pagi", page)
            },
        },
        computed: {
            isActive: function() {
                return this.users.current_page;
            },
            pageNumber: function() {
                if (!this.users.to) return [];

                var from = this.users.current_page - this.offset;
                if (from < 1) from = 1;

                var to = from + (this.offset * 2);
                if (to >= this.users.last_page) to = this.users.last_page;

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
        },
    };
</script>

<style lang="css">
:root{
    --pink: #0B6496;
}
    .btn-pink {
        background-color: var(--pink);
        color: #fff;
    }

    .list-group-item>span {
        position: relative;
        top: 17%;
    }

    .list-group .current{
        background-color: #053051;
    }

    .border-left-radius{
        border-top-left-radius: 20px !important;
        border-bottom-left-radius: 20px !important;
    }

    .border-right-radius{
        border-top-right-radius: 20px !important;
        border-bottom-right-radius: 20px !important;
    }
</style>
