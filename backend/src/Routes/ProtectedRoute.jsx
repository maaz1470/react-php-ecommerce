/* eslint-disable prettier/prettier */
/* eslint-disable react/prop-types */
/* eslint-disable prettier/prettier */
import React, { useContext } from 'react';
import { Navigate } from 'react-router-dom';
import { AuthContext } from 'src/Provider/AuthProvider';

const ProtectedRoute = ({children}) => {
    const {auth} = useContext(AuthContext)
    if(auth){
        return children;
    }else{
        return <Navigate to={'/auth/login'} replace />
    }
};

export default ProtectedRoute;