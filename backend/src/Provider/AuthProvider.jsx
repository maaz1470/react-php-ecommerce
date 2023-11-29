/* eslint-disable prettier/prettier */
/* eslint-disable react/prop-types */


import axios from 'axios'
import React, { createContext, useEffect, useState } from 'react'

export const AuthContext = createContext(null)

const AuthProvider = ({ children }) => {
    const [auth, setAuth] = useState(false)

    useEffect(() => {
        // axios.get()
    },[])

    const userInfo = {
        auth
    }
    return (
        <AuthContext.Provider value={userInfo}>
            {children}
        </AuthContext.Provider>
    );
}

export default AuthProvider
