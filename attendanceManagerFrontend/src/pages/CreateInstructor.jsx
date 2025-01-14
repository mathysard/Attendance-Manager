import React from 'react'
import axios from 'axios';

function CreateInstructor() {
  if(localStorage.getItem('isAdmin') === null || (localStorage.getItem('isAdmin') !== null && localStorage.getItem('isAdmin') === "false")) {
    window.location.assign('/');
  }

  const handleSubmit = async (e) => {
    e.preventDefault();

    const target = e.target;

    await axios.get(`http://localhost:8000/instructor/create?firstName=${target[0].value}&lastName=${target[1].value}&email=${target[2].value}&password=${target[3].value}`)
    .then(() => {
      window.location.assign('/attendance');
    })
  }

  return (
    <div className="flex justify-center mt-16">
      <div>
        <form className="max-w-sm mx-auto" onSubmit={handleSubmit}>
          <div className="mb-5">
            <label htmlFor="firstName" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
            <input type="firstName" id="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
          </div>
          <div className="mb-5">
            <label htmlFor="lastName" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
            <input type="lastName" id="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
          </div>
          <div className="mb-5">
            <label htmlFor="email" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail</label>
            <input type="email" id="email" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
          </div>
          <div className="mb-5">
            <label htmlFor="password" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
            <input type="password" id="password" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
          </div>
          <input type="submit" className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Créer" />
        </form>

        {/* <a href="">Assigner une classe à un professeur</a> */}
      </div>
    </div>
  )
}

export default CreateInstructor