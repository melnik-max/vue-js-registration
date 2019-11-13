<template>
    <div class="form-group">
        <label v-bind:for="name">{{ label }}</label>
        <input v-bind:type="type" v-model="fields.first_name" v-bind:maxlength="maxlength" class="form-control form-control-lg" v-bind:id="name" v-bind:name="name" v-bind:placeholder="placeholder" required>
    </div>
</template>

<script>
    export default {
      name: 'FormControl',
      props: ['name', 'type', 'maxlength', 'placeholder', 'label']
    }
</script>
