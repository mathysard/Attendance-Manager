import React from 'react'

function Homepage() {
  return (
    <div className="flex justify-center">
        <p className="text-3xl font-semibold">Gestionnaire de présences</p>
        <a href="/auth" className="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-800 hover:cursor-pointer active:bg-blue-900 shadow-xl">Se connecter</a>
    </div>
  )
}

export default Homepage