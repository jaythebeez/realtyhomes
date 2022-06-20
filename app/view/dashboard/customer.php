<div class="headline">
    <h1>Customer</h1>
</div>

<div class="dashboard-container">
    <div class="table-container">
        <div class="table-header">
            <h3>My Bids</h3>
        </div>
        <div class="table-content">
        <table id="customer-bids-table"  class="dashboard-table">
            <tr>
                <th style="width:50%">Property</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </table>
        </div>
    </div>
</div>

<script>
    const bidsContainer = document.querySelector('#customer-bids-table');
    if(bidsContainer) {
      const formData = new FormData();
      formData.append("get_customer_bids", true);
      fetch('./api.php', {
        method: "post",
        body:formData
      })
      .then(res=>res.json())
      .then(data=>{
        console.log(data);
        data.forEach(bid=>{
          bidsContainer.insertAdjacentHTML('beforeend', customerBidsMarkup(bid));
        })
        bidsContainer.addEventListener('click', e=>{
            let element = e.target;
            if (element.classList.contains('delete')) {
                let id = element.dataset.id;
                const formData = new FormData();
                formData.append('delete_bid', true);
                formData.append('bid_id', id);
                fetch('./api.php', {
                    method: "post",
                    body:formData
                })
                .then(res=>res.json())
                .then(data=>{
                    if(data.success) window.location.reload();
                })
            }
            else if(element.classList.contains('pay')) {
                let bid_id = element.dataset.id;
                openPaymentModal(bid_id);
            }
        })
      })
      .catch(err=>console.log(err))
    }

    const customerBidsMarkup = data => {
        return `
        <tr>
            <td style="width:50%"><a href="?view=singleproperty#${data.property_id}">${data.title}</a></td>
            <td>${data.bid_price}</td>
            <td>${data.status}</td>
            <td>${condition(data)}</td>
        </tr>
        `
    }


    const condition = (data) => {
        if(data.status == "approved") {
            return `<button class="blue-color pay table-button" data-id="${data.bid_id}" data-target"make_payment">Pay</button>`
        }
        else if (data.status == "confirmed") {
            return `<a href="./assets/mockletter.txt" target="_blank" download="Mock Letter" data-id="${data.bid_id}" data-target="delete_bid">Download Letter</a>`
        }
        else {
            return `<button class="delete table-button" data-id="${data.bid_id}" data-target="delete_bid">Remove</button>`
        }
    }

    const openPaymentModal = (bid_id) => {
        const dashboard = document.querySelector(".dashboard-container");
        dashboard.insertAdjacentHTML("afterbegin", modalMarkup(bid_id));
        const close = document.querySelector(".close");
        close.addEventListener('click', (e)=>{
            closePaymentModal();
        })
        const payForm = document.querySelector("#payment");
        payForm.addEventListener("submit", (e)=>{
            e.preventDefault();
            const payFormData = new FormData(e.target);
            payFormData.append("bid_id", bid_id);
            payFormData.append("confirm_payment", true);
            fetch("./api.php", {
                method: "post",
                body: payFormData
            })
            .then(res=>res.json())
            .then(data=>{
                if (data.success) {
                    showSnackbar("Payment Successful");
                    setTimeout(()=>{
                        window.location.reolad();
                    }, 200)
                }
            })
            .catch(err=>{
                showSnackbar("Payment Was Unsuccessful Please Try Again");
            });
        })
    }

    const closePaymentModal = () => {
        const dashboard = document.querySelector(".dashboard-container");
        const modal = document.querySelector('.modal');
        dashboard.removeChild(modal);
    }

    const modalMarkup = (bid_id) => {
        return `
        <div class="modal">
            <div class="modal-container">
                <span class="close"><img src="./assets/icons/close.svg"></span>
                <div class="modal-header">
                    <h3>Make Payment</h3>
                </div>
                <div class="modal-content">
                    <form name="make_payment" id="payment">    
                        <input type="text" name="password" class="form_input" placeholder="Type in your password">
                        <button class="form_button pay-button" data-id=${bid_id}>Process Payment</button>
                    </form>
                </div>
            </div>
        </div>
        `;

    }
</script>