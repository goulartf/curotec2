<template>
  <div class="container">
    <h1>Add Contact</h1>
    <div class="mb-3">
      <div class="form-group">
        <label>Name</label>
        <input type="text" required name="name" class="form-control" v-model="name"/>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" required name="name" class="form-control" v-model="email"/>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" required name="name" class="form-control" v-model="phone"/>
      </div>

      <button v-if="!edit" class="btn btn-primary" @click="addContact">Add</button>
      <button v-if="edit" class="btn btn-primary" @click="editContact(id)">Edit</button>
    </div>

    <h1>Contacts</h1>

    <table class="table table-stripped">
      <tr v-for="(contact, index) in contacts" :key="index">
        <td>{{ contact.name }}</td>
        <td>{{ contact.email }}</td>
        <td>{{ contact.phone }}</td>
        <td class="text-center">
          <button class="btn btn-primary mr-2" @click="formContact(contact.id)">Edit</button>
          <button class="btn btn-danger" @click="deleteContact(contact.id)">Delete</button>
        </td>
      </tr>
    </table>

  </div>
</template>

<script>

import axios from "axios";

export default {
  name: 'App',
  data() {
    return {
      name: '',
      email: '',
      phone: '',
      contacts: [],
      edit: false,
      id: ''
    }
  },
  async mounted() {
    const response = await axios.get('http://localhost:8000/api/contacts');
    this.contacts = response.data;
  },
  methods: {
    async addContact() {

      if (this.name === '' || this.email === '' || this.phone === '') {
        return alert('all fields are required')
      }

      const response = await axios.post('http://localhost:8000/api/contacts', {name: this.name, email: this.email, phone: this.phone});

      this.contacts.unshift(response.data);

      //reset form
      this.name = '';
      this.email = '';
      this.phone = '';
    },
    formContact(_id) {
      const contact = this.contacts.find(contact => contact.id === _id);

      this.edit = true;
      this.id = _id;
      this.name = contact.name;
      this.email = contact.name;
      this.phone = contact.phone;
    },
    async editContact(_id) {
      if (this.name === '' || this.email === '' || this.phone === '') {
        return alert('all fields are required')
      }

      await axios.put('http://localhost:8000/api/contacts/'+_id, {name: this.name, email: this.email, phone: this.phone});

      this.contacts = this.contacts.map(contact => {
        if (contact.id === _id) {
          contact.name = this.name;
          contact.email = this.email;
          contact.phone = this.phone;
        }

        return contact;
      });

      this.edit = false;
      this.id = '';
      this.name = '';
      this.email = '';
      this.phone = '';
    },
    async deleteContact(_id) {
      await axios.delete('http://localhost:8000/api/contacts/'+_id);

      this.contacts = this.contacts.filter(contact => {
        return contact.id !== _id;
      });
    }
  },
  computed: {
    allContacts() {
      return this.contacts;
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
