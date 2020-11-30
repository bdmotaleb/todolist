<template>
    <div class="item-add">
        <input type="text" v-model="name">
        <font-awesome-icon @click="addItem()" icon="plus-square" :class="[this.name ? 'active':'inactive', 'plus']"/>
    </div>
</template>

<script>
export default {
    name: "Create",
    data: function () {
        return {
            name: null
        }
    },
    methods: {
        addItem: function () {
            if (this.name !== null) {
                axios.post('http://127.0.0.1:8000/api/item/', { name: this.name })
                    .then(response => {
                        if (response.status === 200) {
                            this.name = null
                            this.$emit('reloadList')
                        }
                    }).catch(error => {

                })
            }
        }
    }
}
</script>

<style scoped>
.item-add {
    display: flex;
    justify-content: center;
    align-items: center;
}

.item-add input {
    border: 1px solid #ddd;
    outline: none;
    width: 100%;
    padding: 5px;
    border-radius: 4px;
    margin-right: 10px;
    font-size: 16px
}

.item-add input:focus {
    border: 1px solid #0083C1;
}

.plus {
    font-size: 20px;
    cursor: pointer;
}

.active {
    color: #0083C1;
}

.inactive {
    color: #a9aba9;
}
</style>
