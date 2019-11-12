<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <input :type="type" :maxlength="maxlength" class="form-control form-control-lg" :id="name" :name="name" :placeholder="placeholder" required>
    </div>
</template>

<script>
    export default {
      name: 'FormControl',
      props: ['name', 'type', 'maxlength', 'placeholder', 'label']
    }
</script>
