<template>
    <div class="main">
        <h2 class="heading">Todo List</h2>
        <create-form v-on:reloadList="getData"></create-form>
        <list-items :items="items" v-on:reloadList="getData"></list-items>
    </div>
</template>

<script>
import Create from "./Create";
import List from "./List";

export default {
    name: "App",
    data: function () {
        return {
            items: {}
        }
    },
    components: {
        'create-form': Create,
        'list-items': List,
    },
    methods: {
        getData() {
            axios.get('http://127.0.0.1:8000/api/item/')
                .then(response => {
                    this.items = response.data.data
                }).catch(error => {

            })
        }
    },
    created() {
        this.getData()
    }
}
</script>
