import React from 'react'
import axios from 'axios'

function Auth() {
    const handleSubmit = async (e) => {
        e.preventDefault();
        // En raison du manque de temps et de problèmes que j'ai pas réussi à régler avec CORS, pas le choix, je passe ça en URL
        await axios.get(`http://localhost:8000/authenticate?email=${e.target[0].value}&password=${e.target[1].value}`)
        .then(data => {
            if(data.data.message) {
                localStorage.setItem(data.data.isAdmin === true ? "administrator" : "instructor", data.data.isAdmin === true ? data.data.admin : data.data.instructor);
                localStorage.setItem("isAdmin", data.data.isAdmin);
                window.location.assign("/attendance");
            } else {
                console.error("The account was not retrieved successfully.");
            }
        })
    }

    if(localStorage.getItem('isAdmin') !== null) {
        window.location.assign('/attendance');
    }

  return (
    <>
        <div className="mt-32">
            <form className="max-w-sm mx-auto" method="POST" onSubmit={handleSubmit}>
                <div className="mb-5">
                    <label htmlFor="email" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail</label>
                    <input type="email" id="email" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <div className="mb-5">
                    <label htmlFor="password" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                    <input type="password" id="password" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <input type="submit" className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Connexion" />
            </form>
        </div>
    </>
  )
}

export default Auth