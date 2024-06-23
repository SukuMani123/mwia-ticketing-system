// PayPalButton.js
import React from "react";
import { useNavigate } from "react-router-dom";
import SuccessPage from "./SuccessPage";


function PayPalButton({ amount, invoice, paymentReferenceNumber }) {
    const navigate = useNavigate();

    const referenceNumber = paymentReferenceNumber;
    const returnUrl= `http://localhost:3000/SuccessPage?paymentReferenceNumber=${paymentReferenceNumber}&paidStatus=1`;
    const cancelReturnUrl = `http://localhost:3000/FailurePage?paymentReferenceNumber=${paymentReferenceNumber}&paidStatus=0`;
    
    const handleClick = () => {
    const form = document.createElement("form");
    form.action = "https://www.sandbox.paypal.com/cgi-bin/webscr?locale=de_DE";
    //form.action = "https://www.paypal.com/cgi-bin/webscr?locale=de_DE";
    form.method = "post";
    
    const fields = [
      { name: "cmd", value: "_xclick" },
      { name: "redirect_cmd", value: "_xclick" },
     // { name: "hosted_button_id", value: "YW6R4JZCK4ZQG" },
      { name: "currency_code", value: "EUR" },
      { name: "amount", value: amount },
      { name: "invoice", value: referenceNumber },
      { name: "business", value: "ramrc007@gmail.com" },
      { name: "country_code", value: "DE" },
      { name: "postal_code", value: "65760" },
      { name: "lc", value: "de_DE" },
      { name: "return", value: returnUrl },
      { name: "cancel_return", value: cancelReturnUrl , id:"cancel_return" },
      { name: "charset", value: "utf-8"}
    ];

    fields.forEach((field) => {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = field.name;
      input.value = field.value;
      form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
  };
  const handleClickTest = () =>{
    navigate("/SuccessPage");
  }

  return (
    <div>

      <button onClick={handleClick} type="button">
        Pay Now
      </button>
    
      {/* <form action="https://www.sandbox.paypal.com/cgi-bin/webscr?locale=de_DE" method="post" target="_top">
          <input type="hidden" name="cmd" value="_ext-enter"  />
          <input type="hidden" name="redirect_cmd" value="_xclick"  />
          <input type="hidden" name="hosted_button_id" value="YW6R4JZCK4ZQG" /> 
          <input type="hidden" name="currency_code" value="EUR" />
          <input type="hidden" name="amount" value="0.50" />
          <input type="hidden" name="invoice" value={referenceNumber} />
          <input type="hidden" name="business" value="ramrc007@gmail.com" />
          <input type="hidden" name="country_code" value="DE"  />
          <input type="hidden" name="postal_code" value="65760"  />
          <input type="hidden" name="lc" value="de_DE"  />
          <input type="hidden" value={returnUrl}name="return"  />
          <input type="hidden" name="cancel_return" id="cancel_return" value={cancelReturnUrl} />
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
      </form> */}

    </div>
  );
}

export default PayPalButton;
