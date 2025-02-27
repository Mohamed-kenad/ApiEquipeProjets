import { useEffect, useState } from 'react'

import axios from 'axios';

function App() {
  const [personnes, setPersonnes] = useState([]);

  useEffect(()=>{
    axios.get('/api/personnes')
    .then((res)=>setPersonnes(res.data.data))

  },[])



  return (
    <>
    <div className='container'>

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
