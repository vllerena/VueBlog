<template>
  <div>
      <Modal
          :value="getDeleteModalObj.showDeleteModal()"
          width="360">
          <p slot="header" style="color:#f60;text-align:center">
              <Icon type="ios-information-circle"></Icon>
              <span>Delete confirmation</span>
          </p>
          <div style="text-align:center">
              <p>Are u sure u want to delete this tag?</p>
          </div>
          <div slot="footer">
              <Button type="error" size="large" long @click="deleteTag" :disabled="isDeleting" :loading="isDeleting">
                  {{ isDeleting ? 'Deleting...' : 'Delete Tag' }}</Button>
          </div>
      </Modal>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: "deleteModal",
    data(){
      return {
          isDeleting: false,
      }
    },
    methods: {
        async deleteTag(){
            this.isDeleting = true
            const res = await this.callApi('post', getDeleteModalObj.deleteUrl, getDeleteModalObj.data);
            if(res.status === 200){
                this.success('Tag has been deleted successfully!')
            } else {
                this.swr()
            }
            this.isDeleting = false
            this.deleteModal = false
        },
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    }
}
</script>

<style scoped>

</style>
