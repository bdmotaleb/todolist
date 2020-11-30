<template>
    <div class="items">
        <ul>
            <li v-for="item in items">
                <span class="item-checkbox">
                    <input type="checkbox" :checked="item.completed" @click="updaateItem(item.id, item.completed)">
                </span>
                <span :class="[item.completed ? 'completed':'', 'item-name']">{{ item.name }}</span>
                <span class="item-trash" @click="removeItem(item.id)"><font-awesome-icon icon="trash"></font-awesome-icon></span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "List",
    props: ['items'],
    methods: {
        removeItem: function (id) {
            axios.delete('http://127.0.0.1:8000/api/item/' + id)
                .then(response => {
                    this.$emit('reloadList')
                }).catch(error => {

            })
        },
        updaateItem: function (id, status) {
            axios.put('http://127.0.0.1:8000/api/item/' + id, { completed: !status })
                .then(response => {
                    this.$emit('reloadList')
                }).catch(error => {

            })
        }
    }
}
</script>

<style scoped>
ul {
    list-style: none;
    margin-top: 20px;
}

ul li {
    background: #f7f7f7;
    padding: 5px;
    border-radius: 4px;
    border-bottom: 1px solid #dddddd;
    margin: 3px 0;
    display: flex;
    position: relative;
}

.item-checkbox {
    margin-right: 5px;
}

.completed {
    text-decoration: line-through;
}

.item-trash {
    color: red;
    position: absolute;
    right: 5px;
    cursor: pointer;
}
</style>
