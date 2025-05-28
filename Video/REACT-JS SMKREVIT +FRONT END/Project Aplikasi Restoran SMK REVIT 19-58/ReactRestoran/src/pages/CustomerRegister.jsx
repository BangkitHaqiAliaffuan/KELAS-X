import React, { useState } from 'react';
import { useForm } from 'react-hook-form';
import { useNavigate, Link } from 'react-router-dom';
import axios from 'axios';

const CustomerRegister = () => {
  const navigate = useNavigate();
  const [registerLoading, setRegisterLoading] = useState(false);
  const [registerError, setRegisterError] = useState(null);
  const { register, handleSubmit, formState: { errors }, watch } = useForm();

  const onSubmit = async (data) => {
    try {
      setRegisterLoading(true);
      setRegisterError(null);

      const response = await axios.post('http://localhost:8000/api/register-pelanggan', {
        pelanggan: data.name,
        email: data.email,
        password: data.password,
        alamat: data.alamat,
        telp: data.telp
      });

      if (response.data.status) {
        navigate('/customer-login', { 
          state: { message: 'Registration successful! Please login.' } 
        });
      }
    } catch (error) {
      setRegisterError(
        error.response?.data?.message ||
        'Registration failed. Please try again.'
      );
    } finally {
      setRegisterLoading(false);
    }
  };

  return (
    <div className="container mt-5">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <div className="card">
            <div className="card-body">
              <h2 className="text-center mb-4">Register as Customer</h2>
              {registerError && (
                <div className="alert alert-danger" role="alert">
                  {registerError}
                </div>
              )}
              <form onSubmit={handleSubmit(onSubmit)}>
                <div className="mb-3">
                  <label htmlFor="name" className="form-label">Name</label>
                  <input
                    type="text"
                    className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                    id="name"
                    {...register('name', { required: 'Name is required' })}
                  />
                  {errors.name && (
                    <div className="invalid-feedback">{errors.name.message}</div>
                  )}
                </div>

                <div className="mb-3">
                  <label htmlFor="email" className="form-label">Email</label>
                  <input
                    type="email"
                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                    id="email"
                    {...register('email', {
                      required: 'Email is required',
                      pattern: {
                        value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                        message: 'Invalid email address'
                      }
                    })}
                  />
                  {errors.email && (
                    <div className="invalid-feedback">{errors.email.message}</div>
                  )}
                </div>

                <div className="mb-3">
                  <label htmlFor="alamat" className="form-label">Address</label>
                  <textarea
                    className={`form-control ${errors.alamat ? 'is-invalid' : ''}`}
                    id="alamat"
                    rows="3"
                    {...register('alamat', { required: 'Address is required' })}
                  ></textarea>
                  {errors.alamat && (
                    <div className="invalid-feedback">{errors.alamat.message}</div>
                  )}
                </div>

                <div className="mb-3">
                  <label htmlFor="telp" className="form-label">Phone Number</label>
                  <input
                    type="text"
                    className={`form-control ${errors.telp ? 'is-invalid' : ''}`}
                    id="telp"
                    {...register('telp', { 
                      required: 'Phone number is required',
                      pattern: {
                        value: /^[0-9]+$/,
                        message: 'Please enter valid phone number'
                      }
                    })}
                  />
                  {errors.telp && (
                    <div className="invalid-feedback">{errors.telp.message}</div>
                  )}
                </div>

                <div className="mb-3">
                  <label htmlFor="password" className="form-label">Password</label>
                  <input
                    type="password"
                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                    id="password"
                    {...register('password', {
                      required: 'Password is required',
                      minLength: {
                        value: 6,
                        message: 'Password must be at least 6 characters'
                      }
                    })}
                  />
                  {errors.password && (
                    <div className="invalid-feedback">{errors.password.message}</div>
                  )}
                </div>

                <div className="mb-3">
                  <label htmlFor="confirmPassword" className="form-label">Confirm Password</label>
                  <input
                    type="password"
                    className={`form-control ${errors.confirmPassword ? 'is-invalid' : ''}`}
                    id="confirmPassword"
                    {...register('confirmPassword', {
                      required: 'Please confirm your password',
                      validate: value =>
                        value === watch('password') || 'Passwords do not match'
                    })}
                  />
                  {errors.confirmPassword && (
                    <div className="invalid-feedback">{errors.confirmPassword.message}</div>
                  )}
                </div>

                <button
                  type="submit"
                  className="btn btn-success w-100"
                  disabled={registerLoading}
                >
                  {registerLoading ? 'Registering...' : 'Register'}
                </button>

                <div className="text-center mt-3">
                  Already have an account? <Link to="/customer-login">Login here</Link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CustomerRegister;
