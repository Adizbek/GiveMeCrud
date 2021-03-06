<template>
  <b-container fluid>
    <b-row>
      <b-col sm="12" class="mt-2">
        <div class="card">
          <div class="card-header">{{edit ? 'Edit' : 'Add'}} {{entity}}</div>

          <div class="card-body">
            <form-field :key="field.name"
                        :field="field"
                        v-model="field.data"
                        v-for="field in fields"/>
          </div>

          <div class="card-footer text-right">
            <b-btn variant="warning" size="sm" @click="resetForm()">Reset</b-btn>

            <b-btn v-if="!edit" variant="primary" size="sm" @click="create(true)">Create & Add another</b-btn>
            <b-btn v-if="!edit" variant="primary" size="sm" @click="create(false)">Create</b-btn>

            <b-btn v-if="edit" variant="primary" size="sm" @click="save(true)">Save & Continue editing</b-btn>
            <b-btn v-if="edit" variant="primary" size="sm" @click="save(false)">Save</b-btn>
          </div>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import LToast from "../core/LToast";
import {LarabekEvents} from "../core/consts";

export default {
  name: "FormPage",

  data() {
    return {
      item: {},

      edit: !!this.$route.params.id
    }
  },

  created() {
    this.loadEntity()
  },

  methods: {
    loadEntity() {
      if (this.edit) {
        this.$http.get(`form/${this.entity}/${this.id}`).then(res => {
          this.item = res.data
        })
      } else {
        this.$http.get(`form/${this.entity}`).then(res => {
          this.item = res.data
        })
      }
    },

    resetForm() {
      Larabek.emit(LarabekEvents.ResetField);
    },

    save(continueEditing = false) {
      this.$http.post(`form/${this.entity}/${this.id}`, {
        data: this.fields
      }).then(res => {
        this.item = res.data

        if (!continueEditing)
          Larabek.navigation.openSheet(this.entity);

        LToast.show('success', 'Success', 'Entity has been saved')
      }).catch(e => {
        LToast.show('danger', 'Error', e.response.data.message)
      })
    },

    create(addNew = false) {
      this.$http.post(`form/${this.entity}`, {
        data: this.fields
      }).then(res => {
        this.item = res.data

        if (!addNew) {
          Larabek.navigation.openSheet(this.entity);
        } else {
          this.resetForm();
        }

        LToast.show('success', 'Success', 'Entity has created')
      }).catch(e => {
        LToast.show('danger', 'Error', e.response.data.message)
      })
    }
  },


  computed: {
    entity() {
      return this.$route.params.entity
    },

    id() {
      return this.$route.params.id
    },

    model() {
      return this.item.model
    },

    fields() {
      return this.item.fields
    },

    actions() {
      return this.item.actions
    }
  }
}
</script>

<style scoped>

</style>
