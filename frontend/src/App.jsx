import { useEffect, useState } from 'react'

import axios from 'axios';

function App() {
  const [personnes, setPersonnes] = useState([]);
  const [formData, setFormData] = useState({
    nom: "",
    prenom: "",
    telephone: "",
    ville: "",
  });

  useEffect(()=>{
   axios.get('/api/personnes')
    .then((res)=>setPersonnes(res.data.data))

  },[])

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('/api/personnes',formData)
    .then((res)=>setPersonnes([...personnes,res.data.data]))
    setFormData({
      nom: "",
      prenom: "",
      telephone: "",
      ville: "",
    });

  }



  return (

    <>
      <div className="container mt-10 w-50 p-10">
      <h2 className="mb-4">User Registration</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label htmlFor="first_name" className="form-label">First Name</label>
          <input
            type="text"
            className="form-control"
            id="first_name"
            name="nom"
            value={formData.nom}
            onChange={handleChange}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="last_name" className="form-label">Last Name</label>
          <input
            type="text"
            className="form-control"
            id="last_name"
            name="prenom"
            value={formData.prenom}
            onChange={handleChange}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="phone" className="form-label">Phone</label>
          <input
            type="text"
            className="form-control"
            id="phone"
            name="telephone"
            value={formData.telephone}
            onChange={handleChange}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="city" className="form-label">City</label>
          <input
            type="text"
            className="form-control"
            id="city"
            name="ville"
            value={formData.ville}
            onChange={handleChange}
            required
          />
        </div>
        <button type="submit" className="btn btn-primary">Submit</button>
      </form>
      </div>
    <div className='container mt-2'>

    <table  className="table table-striped table-hover">
      <thead className='table-dark'>
        <tr>
          <th>id</th>
          <th>nom</th>
          <th>prenom</th>
          <th>telephoe</th>
          <th>ville</th>
        </tr>
      </thead>
      <tbody>
        {personnes.map((p,i)=>(
          <tr key={i}>
            <td>{p.id}</td>
            <td>{p.nom}</td>
            <td>{p.prenom}</td>
            <td>{p.telephone}</td>
            <td>{p.ville}</td>
          </tr>
        ))}
        <tr></tr>
      </tbody>
    </table>

            </div>
    </>
  )
}

export default App
