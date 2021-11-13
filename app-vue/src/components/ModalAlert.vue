<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header"><h4 class="text-center w-100">{{ title }}</h4></slot>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body text-center">
            <slot name="body">
              <div v-html="body"></div>
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              <button class="btn btn-secondary" @click="closeModal" v-html="close_btn"></button>
              <button :class="confirm_btn_class" v-if="confirm_callback" @click="confirmModal" v-html="confirm_btn"></button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "ModalAlert",
  props: {
    title: String,
    body: String,
    close_callback: {
      default: false,
    },
    confirm_callback: {
      default: false,
    },
    close_btn: {
      type: String,
      default: 'Chiudi',
    },
    confirm_btn: {
      type: String,
      default: 'OK',
    },
    confirm_btn_class: {
      type: String,
      default: 'btn btn-primary',
    },
    confirm_callback_function: Function,

  },
  data() {
    return {
      show_modal: true
    }
  },
  methods: {
    closeModal() {
      if (this.close_callback) {
        this.close_callback();
      }
      this.$emit('remove-unused-modal-alert');
      this.$emit('close');
    },
    confirmModal() {
      if (this.confirm_callback) {
        if (this.confirm_callback_function) {
          this.confirm_callback_function();
        } else {
          this.$emit('confirm_callback');
        }

      }
      this.$emit('remove-unused-modal-alert');
      this.$emit('close');
    },

  }

}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 400px;
  max-width: 95vw;
  margin: 0px auto;
  padding: 0;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
  margin-bottom: 0;
  line-height: 1.5;
}

.modal-body {
  margin: 20px 0;
  padding: 8px;
}


.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.modal-footer .btn {
  margin: 0 auto;
}
</style>