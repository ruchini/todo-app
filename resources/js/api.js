import axios from 'axios';

const API_BASE_URL = '/api'; // Update with your API base URL

// Function to fetch the list of notes
export const fetchNotes = () => {
  return axios.get(`${API_BASE_URL}/todo-notes`)
    .then(response => {
      if (response.data.status_code === 200) {
        return response.data.data;
      }
      throw new Error('Failed to fetch notes.');
    });
};

// Function to add a new note
export const addNote = (newNote) => {
  return axios.post(`${API_BASE_URL}/todo-notes`, newNote)
    .then(response => {
      if (response.data.status_code === 200) {
        return response.data.data;
      }
      throw new Error('Failed to add note.');
    });
};

// Function to delete a note
export const deleteNote = (noteId) => {
  return axios.delete(`${API_BASE_URL}/todo-notes/${noteId}`)
    .then(() => {
      return true;
    })
    .catch(error => {
      throw new Error('Failed to delete note.');
    });
};
