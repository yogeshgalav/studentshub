<template>
  <div class="base-input">
    <font-awesome-icon v-if="icon && isAlignLeftIcon" :icon="icon" class="left-icon"/>
    <input
      ref="baseInput"
      v-model="inputValue"
      :type="toggleType"
      :disabled="disabled"
      :readonly="readOnly"
      :name="name"
      :tabindex="tabIndex"
      :class="[{'input-field-left-icon': icon && isAlignLeftIcon ,'input-field-right-icon': icon && !isAlignLeftIcon ,'invalid': isFieldValid, 'disabled': disabled, 'small-input': small}, inputClass]"
      :placeholder="placeholder"
      :autocomplete="autocomplete"
      class="form-control input-field"
      @input="handleInput"
      @change="handleChange"
      @keyup="handleKeyupEnter"
      @keydown="handleKeyDownEnter"
      @blur="handleFocusOut"
    >
    <div v-if="showPassword && isAlignLeftIcon" style="cursor: pointer" @click="showPass = !showPass" >
      <font-awesome-icon :icon="!showPass ?'eye': 'eye-slash'" class="right-icon" />
    </div>
    <font-awesome-icon v-if="icon && !isAlignLeftIcon" :icon="icon" class="right-icon" />
  </div>
</template>
<style lang="scss" scoped>
.base-input {
    width: 100%;
    position: relative;

    .left-icon {
        position: absolute;
        width: 13px;
        height: 18px;
        min-width: 40px;
    
        font-style: normal;
        font-weight: 900;
        font-size: 14px;
        line-height: 16px;
        top: 50%;
        left: 20px;
        z-index: 1;
        transform: translate(-50%,-50%);
    }

    .right-icon {
        position: absolute;
        width: 13px;
        height: 18px;
        min-width: 18px;
      
        font-style: normal;
        font-weight: 900;
        font-size: 14px;
        line-height: 16px;
        top: 50%;
        right: 0px;
        z-index: 1;
        transform: translate(-50%, -50%);
    }

    .small-input {
        max-width: 100px;
    }

    .input-field {
        width: 100%;
        height: 40px;
        padding: 12px 13px;
        text-align: left;
        background: #eee;
        border: 1px solid #ccc;
        box-sizing: border-box;
        border-radius: 0px;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 21px;

        &.v-money {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        &::placeholder {
            font-family: Poppins;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            line-height: 21px
        }

        &:focus {
            border: 1px solid #817AE3;
        }

        &.invalid {
            border: 1px solid #FB7178 !important;
        }


        &-left-icon {
            padding-left: 35px;
        }

        &-right-icon {
            padding-right: 35px;
        }
    }
}

</style>
<script>
export default {
  props: {
    name: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    tabIndex: {
      type: String,
      default: ''
    },
    value: {
      type: [String, Number, File],
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    invalid: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    readOnly: {
      type: Boolean,
      default: false
    },
    icon: {
      type: String,
      default: ''
    },
    inputClass: {
      type: String,
      default: ''
    },
    small: {
      type: Boolean,
      default: false
    },
    alignIcon: {
      type: String,
      default: 'left'
    },
    autocomplete: {
      type: String,
      default: 'on'
    },
    showPassword: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      inputValue: this.value,
      focus: false,
      showPass: false
    }
  },
  computed: {
    isFieldValid () {
      return this.invalid
    },
    isAlignLeftIcon () {
      if (this.alignIcon === 'left') {
        return true
      }
      return false
    },
    toggleType () {
      if (this.showPass) {
        return 'text'
      }
      return this.type
    }
  },
  watch: {
    'value' () {
      this.inputValue = this.value
    },
    focus () {
      this.focusInput()
    }
  },
  mounted () {
    this.focusInput()
  },
  methods: {
    focusInput () {
      if (this.focus) {
        this.$refs.baseInput.focus()
      }
    },
    handleInput (e) {
      this.$emit('input', this.inputValue)
    },
    handleChange (e) {
      this.$emit('change', this.inputValue)
    },
    handleKeyupEnter (e) {
      this.$emit('keyup', this.inputValue)
    },
    handleKeyDownEnter (e) {
      this.$emit('keydown', e, this.inputValue)
    },
    handleFocusOut (e) {
      this.$emit('blur', this.inputValue)
    }
  }
}
</script>
