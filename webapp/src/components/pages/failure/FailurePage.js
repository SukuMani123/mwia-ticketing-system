import { useLocation } from 'react-router-dom';
import { useNavigate } from "react-router-dom";
import React, { useEffect } from 'react';
import Header from "../../header/Header";
const FailurePage = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const queryParams = new URLSearchParams(location.search);

  const paymentReferenceNumber = queryParams.get('paymentReferenceNumber');
  const payerid = queryParams.get("payerid");
  const handleClick = (e) => {
    e.preventDefault();
    navigate("/");
  };
  useEffect(() => {
    // Define the API URL and parameters
    const apiUrl = "";

    // Call the API
    const callApi = async () => {
      try {
        const response = await fetch(apiUrl);
        if (response.ok) {
          const data = await response.json();
          console.log('API call success:', data);
          // Handle the API response data as needed
        } else {
          console.error('API call failed:', response.status);
        }
      } catch (error) {
        console.error('API call error:', error);
      }
    };

    callApi();
  }, [paymentReferenceNumber]);


  return (
    <>
      <div className="App">
        <Header/>
        <hr className="divider" />
        <div className="text-container">
          <h2 className="h2">
            Mainz-Wiesbaden Indian Association (MWIA) inviting You and Your
            Family to be part of Our Summer Grill Fest
          </h2>
        </div>
        <div className="form-container">
          <h2>Congratulations</h2>
          <hr className="dividerSpace26" />
          <p style={{color:"red"}} className="h2small">Your Payment is failed.</p>
          <p className="h2small">
            Confirmation email has been send to your email id{" "}
          </p>
          <div className="text-container">
            <button
              style={{ backgroundColor: "#D9D9D9", color: "black" }}
              onClick={handleClick}
              type="button"
            >
              Go Home
            </button>
          </div>
        </div>
      </div>
    </>
  );
};

export default FailurePage;
