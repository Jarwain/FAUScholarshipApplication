<template>
  <b-form @submit="onSubmit">
    <b-card no-body>
      <b-tabs card>
        <b-tab title="Website" active>
          <b-form-row>
            <b-col>
              <b-form-group id="category"
                          label="Category"
                          label-for="categoryInput">
                <b-form-select id="categoryInput" 
                              v-model="newScholarship.category" 
                              :options="categories" 
                              class="" />
              </b-form-group>
            </b-col>
          </b-form-row>
          <b-form-row v-if="newScholarship.category !== null">
            <b-col cols="1">
              <b-form-group id="active"
                          label="Active"
                          label-for="activeInput">
                <b-button id="activeInput"
                          :pressed.sync="newScholarship.active" 
                          :variant="newScholarship.active ? 'success' : 'danger'">
                  {{ newScholarship.active ? "Active" : "Inactive" }}
                </b-button>
              </b-form-group>
            </b-col>
            <b-col cols="2" v-if="newScholarship.category !== 3">
              <b-form-group id="code"
                          label="Code"
                          label-for="codeInput">
                <b-form-input id="codeInput" 
                              v-model="newScholarship.id" 
                              placeholder="Example: SFA123" />
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group id="name"
                          label="Name"
                          label-for="nameInput">
                <b-form-input id="nameInput" 
                              v-model="newScholarship.name" 
                              placeholder="Scholarship Name" />
              </b-form-group>
            </b-col>
          </b-form-row>
          <b-form-row v-if="newScholarship.category !== null">
            <b-col>
              <b-form-group id="url"
                          label="Link"
                          label-for="urlInput">
                <b-form-input id="urlInput" 
                              v-model="newScholarship.url" 
                              placeholder="Scholarship Link" />
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group id="deadline"
                          label="Deadline"
                          label-for="deadlineInput">
                <b-form-input id="deadlineInput" 
                              v-model="newScholarship.deadline" 
                              placeholder="Example: 2018/04/20" />
              </b-form-group>
            </b-col>
          </b-form-row>
          <b-form-row v-if="newScholarship.category !== null">
            <b-col>
              <b-form-group id="description"
                          label="Description"
                          label-for="descriptionInput">
                <b-form-textarea id="descriptionInput" 
                              v-model="newScholarship.description" 
                              placeholder="Scholarship Description"
                              rows="2"
                              max-rows="4" />
              </b-form-group>
            </b-col>
          </b-form-row>
        </b-tab>
        <b-tab title="Application" v-if="applicationHandler">
          
        </b-tab>  
        <b-tab title="Search" v-if="applicationHandler">
          
        </b-tab>
      </b-tabs>    
      <div slot="footer">
        <b-button type="submit" variant="primary">Save</b-button>
      </div>
    </b-card>
  </b-form>
</template>

<script>
export default {
  name: 'ScholarshipEditor',
  props: {
    scholarship: {
      type: Object,
      default() {
        return {
          category: null,
          id: '',
          name: '',
          description: '',
          url: '',
          deadline: null,
          active: false,
        };
      },
    },
  },
  data() {
    return {
      newScholarship: this.scholarship,
      categories: [
        { text: 'Scholarship Category', value: null, disabled: true },
        { text: 'Online', value: 1 },
        { text: 'Offline', value: 2 },
        { text: 'External', value: 3 },
      ],
      applicationHandler: false,
    };
  },
  methods: {
    onSubmit(e) {
      this.axios.post('https://boc22finaid.fau.edu/scholarship/api/scholarships/', this.newScholarship)
      .then((res) => {
        console.log(res);
      }).catch((err) => {
        console.log(err);
      });
      e.preventDefault();
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.scholarship + .scholarship{
  padding-top: 1.25rem;
}
</style>
