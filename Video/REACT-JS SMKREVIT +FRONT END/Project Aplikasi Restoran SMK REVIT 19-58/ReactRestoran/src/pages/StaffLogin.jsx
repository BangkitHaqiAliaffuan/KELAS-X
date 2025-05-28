import React, { useState, useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const StaffLogin = () => {
  const navigate = useNavigate();
  const [loginLoading, setLoginLoading] = useState(false);
  const [loginError, setLoginError] = useState(null);
  const { register, handleSubmit, formState: { errors } } = useForm();
  const { loginStaff, isAuthenticated, user } = useAuth();

  useEffect(() => {
    if (isAuthenticated && user) {
      switch (user.level) {
        case 'admin':
          navigate('/admin');
          break;
        case 'kasir':
          navigate('/order');
          break;
        case 'koki':
          navigate('/allorderdetails');
          break;
        default:
          navigate('/login');
      }
    }
  }, [isAuthenticated, user, navigate]);

  const onSubmit = async (data) => {
    try {
      setLoginLoading(true);
      setLoginError(null);

      const result = await loginStaff(data.email, data.password);
      if (!result.success) {
        setLoginError(result.message || 'Email atau password salah');
      }
    } catch (err) {
      setLoginError('Terjadi kesalahan saat login');
      console.error('Error login:', err);
    } finally {
      setLoginLoading(false);
    }
  };

  return (
    <div className="container">
      <div className="row justify-content-center align-items-center min-vh-100">
        <div className="col-md-6 col-lg-4">
          <div className="card shadow">
            <div className="card-body p-5">
              <h2 className="text-center mb-4">Staff Login</h2>
              
              {loginError && (
                <div className="alert alert-danger">{loginError}</div>
              )}

              <form onSubmit={handleSubmit(onSubmit)}>
                <div className="mb-3">
                  <label htmlFor="email" className="form-label">Email</label>
                  <input
                    type="email"
                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                    id="email"
                    {...register('email', {
                      required: 'Email harus diisi',
                      pattern: {
                        value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                        message: 'Email tidak valid'
                      }
                    })}
                  />
                  {errors.email && (
                    <div className="invalid-feedback">{errors.email.message}</div>
                  )}
                </div>

                <div className="mb-4">
                  <label htmlFor="password" className="form-label">Password</label>
                  <input
                    type="password"
                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                    id="password"
                    {...register('password', {
                      required: 'Password harus diisi',
                      minLength: {
                        value: 6,
                        message: 'Password minimal 6 karakter'
                      }
                    })}
                  />
                  {errors.password && (
                    <div className="invalid-feedback">{errors.password.message}</div>
                  )}
                </div>

                <button
                  type="submit"
                  className="btn btn-primary w-100"
                  disabled={loginLoading}
                >
                  {loginLoading ? (
                    <>
                      <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      Loading...
                    </>
                  ) : 'Login'}
                </button>
              </form>
              <div className="text-center mt-3">
                <p>Looking for customer login? <a href="/customer-login">Click here</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default StaffLogin;
