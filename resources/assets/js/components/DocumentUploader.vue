<template>

<div>
<!-- File uploader -->
<v-layout wrap justify-center v-if="isSkilledTrade">
  <v-flex xs12>
    <vue-clip
      :options="attachment_upload_options"
      :on-added-file="onAddAttachment"
      :on-removed-file="onDropAttachment"
      class="uploader"
    >
      <template slot="clip-uploader-action">

        <v-card :class="errors.has('attachments') ? 'error':''">
          <v-card-text>
            <p>
              To help us determine your eligibility for a Skilled Trade scholarship, please submit a resume detailing your applicable experience
            </p>
            <v-layout justify-center>
              <div class="uploader-action dz-message">
                <v-card>
                  <v-card-text>
                    <v-icon>cloud_upload</v-icon>
                    &nbsp; Please upload your files
                  </v-card-text>
                </v-card>
              </div>
            </v-layout>
          </v-card-text>
        </v-card>

      </template>
    </vue-clip>

  </v-flex>
  <v-flex xs12>

    <v-card>
      <v-list two-line>
        <template v-for="file in attachments">
          <v-list-tile avatar v-bind:key="file.name" @click="">
            <v-list-tile-avatar>
              <img :src="file.dataUrl" v-if="file.dataUrl">
              <v-icon v-if="getIcon(file.type)" :color="getIcon(file.type).color">
                {{ getIcon(file.type).name }}
              </v-icon>
          </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title v-html="file.name"></v-list-tile-title>
              <v-list-tile-sub-title>
                {{ file.status }}
              </v-list-tile-sub-title>
            </v-list-tile-content>
            <v-list-tile-action>
              <v-btn icon @click="onDropAttachment(file)">
                <v-icon>close</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>
        </template>
      </v-list>
    </v-card>

  </v-flex>
</v-layout>




</div>
</template>

<script>
export default {

  props: {
    url: {
      accept: String,
      required: true,
    }
  },

  data() {
    return {
      attachments: [],
      attachment_upload_options: {
        url: this.$props.url,
        acceptedFiles: 'application/msword,application/pdf,text/plain',
        uploadMultiple: true,
        maxFiles: 4,
        maxFileSize: 2,
      },

    }
  },

  computed: {

    isSkilledTrade() { return true },

  },

  methods: {

    getIcon(type) {
      console.log(type)
      return {
        'application/pdf': { name: 'mdi-file-pdf', color: 'red lighten-2' },
        'application/msword': { name: 'mdi-file-word', color: 'blue' },
        'text/plain': { name: 'mdi-file-document', color: 'grey' },
      }[type]
    },
    onAddAttachment(file) {
      console.log(file)
      this.errors.remove('attachment')
      this.attachments.push(file)
    },
    onDropAttachment(file) {
      axios.post('/api/drop', file.xhrResponse)
        .then(() => {
          let index = this.attachments.indexOf(file)
          this.attachments.splice(index, 1)
        })

          // this.attachments.$remove(file))
        // {
        //   const attached = this.attachments.filter((el) => {
        //     return el.name != file.name;
        //   })
        // })
        .catch(error => this.handleError(error))
    },

    handleError(error) {
      console.log('error',error)
    },
  }

}
</script>
