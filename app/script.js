document.addEventListener('DOMContentLoaded',()=>{

    const state = {};

    const news_button = document.querySelector('.news-button');
    const news = document.querySelector('.news');
    news_button.addEventListener('click', ()=>{
        if(news.classList.contains('show')) {
            news.classList.remove('show');
        }
        else {
            news.classList.add('show');
        }
    })
    
    const stateSelect = document.querySelector('.states');
    if(stateSelect) {
      const citySelect = document.querySelector('.city');
      states.forEach(state=>{
        stateSelect.insertAdjacentHTML('afterbegin', `<option value='${state.name}'>${state.name}</option>`)
      })
      let selectedState = "";
      stateSelect.addEventListener('change',(e)=>{
        citySelect.innerHTML = '';
        selectedState = e.target.selectedOptions[0].innerText;
        let cityList = states.filter(state => {
            if(state.name === selectedState) return state;
        })
        cityList = [...cityList[0].cities];
        cityList.forEach(city => {
            citySelect.insertAdjacentHTML('afterbegin',`<option value='${city}'>${city}</option>` )
        })
      })

      let categrorySelect = document.querySelector('#category-select');
      categrorySelect.addEventListener("change", e=>{
        let selectedCategory = e.target.selectedOptions[0].innerText;
        let houseDiv = document.querySelector('.house-selected');
        console.log(selectedCategory);
        if (selectedCategory === "Land") {
          houseDiv.innerHTML = `
          <label for="area" class="form_label">Total Area</label>
          <input type="text" name="area" class="form_input">
          `;
        }
        else{
          houseDiv.innerHTML = `
          <label for="furnished" class="form_label" >Furnished:</label>
          <select name="furnished" class="form_input">
              <option value="yes">Yes</option>
              <option value="no">No</option>
          </select>
          <label for="rooms" class="form_label">No of Rooms</label>
          <input type="number" name="rooms" class="form_input">
          `;
        }
      })
    }

    const addForm = document.querySelector('#addForm');
    if(addForm) {
      addForm.addEventListener('submit', (e)=>{
        e.preventDefault();
        const image = addForm.querySelector('#image');
        const formData = new FormData(addForm);
        formData.append('image', image.files[0] );
        fullScreenLoader();
        fetch('./api.php', {
          method:"post",
          body:formData
        })
        .then((response)=>response.json())
        .then(data=> {
          if(data.success) {
            showSnackbar("Property added successfully");
          }
          else if (data.error) throw new Error();
        })
        .catch(err=>{
          showSnackbar("Unable to add property");
        })
        .finally(()=>exitScreenLaoder());
      })
    }


    if(window.location.search == "?view=properties") {
      const searchForm = document.querySelector('#searchForm');
      if(searchForm) {
        const props = document.querySelector('.properties-container');
        showPreloader(props);
        const formData = new FormData();
        formData.append('props', true);
        fetch('./api.php',{
          method: 'post',
          body: formData
        }).then((res)=>res.json())
          .then(result=>{
            clearPreloader(props);
            if(result.length) {
              result.forEach(data=>{
                let markup = propsMarkup(data);
                props.insertAdjacentHTML('afterbegin', markup);
              }) 
            }
            else {
              props.insertAdjacentHTML('afterbegin', '<h2>Oops!!! No Properties to show now</h2>')
            }
   
          })
          .catch(err=>clearPreloader(props))

        searchForm.addEventListener('submit', (e)=>{
          e.preventDefault();
          const formData2 = new FormData(e.target);
          formData2.append('search', true);
          fetch('./api.php', {
            method: 'post',
            body: formData2
          }).then(res=>res.json())
            .then(data=>{
              props.innerHTML = '';
              if(data.length) {
                data.forEach(d=>{
                  let markup = propsMarkup(d);
                  props.insertAdjacentHTML('afterbegin', markup);
                })
              }
              else {
                props.insertAdjacentHTML('afterbegin', '<h2>Oops!!! No Properties to show</h2>')
              }
            })
            .catch(err=>clearPreloader(props))
        })
      }
    }

    const filterBtn = document.querySelector('.filter-button');
    if (filterBtn) {
      filterBtn.addEventListener('click', (e)=>{
        const filterModal = document.querySelector('#filterModal');
        if (!state.filter) {
          state.filter = true;
          filterModal.style.display = 'block';
        }
        else {
          state.filter = false;
          filterModal.style.display = 'none';
        }
      })


      const stateDrop = document.querySelector('.state');
      const cityDrop = document.querySelector('.city');
      
      if(stateDrop) {
        states.forEach(state=>{
          stateDrop.insertAdjacentHTML('afterbegin', `<option value='${state.name}'>${state.name}</option>`)
        })
        let selectedState = "";
        stateDrop.addEventListener('change',(e)=>{
          cityDrop.innerHTML = '<option value="none" selected>-none-</option>';
          selectedState = e.target.selectedOptions[0].innerText;
          let cityList = states.filter(state => {
              if(state.name === selectedState) return state;
          })
          cityList = [...cityList[0].cities];
          cityList.forEach(city => {
              citySelect.insertAdjacentHTML('afterbegin',`<option value='${city}'>${city}</option>` )
          })
        })
      }
      
    }

    const addAgentForm = document.querySelector('.add-agent-form');
    if (addAgentForm) {
        addAgentForm.addEventListener('submit', (e)=>{
          e.preventDefault();
          const formData = new FormData(e.target);
          fetch('./api.php', {
              method: 'post',
              body: formData
          })
          .then((res)=>res.json())
          .then(data=>{
            if (data.error) throw new Error(data.error);
            showSnackbar(data.success);
          })
          .catch((e)=>showSnackbar(e));
        })
    }

    const manageUserForm = document.querySelector('.manage-users');
    if (manageUserForm) {
      manageUserForm.addEventListener('submit', (e)=>{
        e.preventDefault();
        const formData = new FormData(manageUserForm);
        const userTable = document.querySelector('#user-table');
        userTable.innerHTML = `     
        <tr>
          <th>UserName</th>
          <th>Role</th>
          <th>Status</th>
          <th>Action</th>
        </tr>`;
        showPreloader(userTable);
        fetch('./api.php', {
          method:'post',
          body:formData
        })
        .then((res)=>res.json())
        .then(data=>{
          clearPreloader(userTable);
          if (data.length) {
            data.forEach(user=>userTable.insertAdjacentHTML('beforeend', userMarkup(user)));
            //add event listener for deactivate account button 
            const deactivate = document.querySelectorAll('.change');
            deactivate.forEach(btn=>{
              btn.addEventListener('click', (e)=>{
                let parent = e.target.parentElement.parentElement;
                let id = parent.attributes.id.value;
                let type = e.target.classList.contains('deactivate') ? 'deactivate' : 'activate';
                let formData2 = new FormData();
                formData2.append('id', id );
                formData2.append(type, true );
                fetch('./api.php', {
                  method: "post", 
                  body: formData2
                })
                .then(res=>res.json())
                .then(data=>{
                  if(data.success) {
                    console.log(data.success);
                    if (type === "activate") {
                      e.target.classList.remove('activate');
                      e.target.classList.add('deactivate');
                      e.target.innerText = 'deactivate'
                    }
                    else {
                      e.target.classList.remove('deactivate');
                      e.target.classList.add('activate');
                      e.target.innerText = 'activate'
                    }
                  }
                  else {
                    showSnackbar("Unable to deativate user")
                  }
                })
                .catch(err=>showSnackbar("Unable to deativate user"))
              })
            })
          }
        })
        .catch(err=>clearPreloader(userTable));
      })


    }

    const addNewsForm = document.querySelector(".add-news");
    if(addNewsForm) {
      addNewsForm.addEventListener('submit', e=>{
        e.preventDefault();
        const formData = new FormData(e.target);
        fetch('./api.php', {
          method:'post', 
          body: formData
        })
        .then(res=>res.json())
        .then(data=>{
          if (data.error){
            throw new Error(data.error);
          }
          else{
            showSnackbar("News Added Successfully");
            window.location.reload();
          }
        })
        .catch(err=>{
          showSnackbar(err);
        })
      })
    }

    const searchNewsForm = document.querySelector(".search-news");
    if(searchNewsForm) {
      searchNewsForm.addEventListener('submit', e=>{
        e.preventDefault();
        const formData = new FormData(e.target);
        const newsTable = document.querySelector('#news-table')
        fetch('./api.php', {
          method:'post', 
          body: formData
        })
        .then(res=>res.json())
        .then(data=>{
          if (data.length) {
            newsTable.innerHTML = `       
            <tr>
              <th style="width:70%">Message</th>
              <th>Action</th>
            </tr>`;
            data.forEach(news=>newsTable.insertAdjacentHTML('beforeend', newsMarkup(news)));
            //add event listener for deactivate account button 
            const deleteBtns = document.querySelectorAll('.delete');
            deleteBtns.forEach(btn=>{
              btn.addEventListener('click', (e)=>{ 
                let id = e.target.attributes.id.value;
                let formData2 = new FormData();
                formData2.append('id', id );
                formData2.append('delete_news', true );
                fetch('./api.php', {
                  method: "post", 
                  body: formData2
                })
                .then(res=>res.json())
                .then(data=>{
                  if(data.success) {
                    let parent = e.target.parentElement.parentElement;
                    parent.style.display = "none";
                  }
                  console.log(data);
                })
                .catch(err=>showSnackbar("Unable to delete news"))
              })
            })
          }
        })
        .catch(err=>console.log(err))
      })
    }

    const propsContainer = document.querySelector('.properties-container');
    if(propsContainer) {
      propsContainer.addEventListener('click', (e)=>{
        e.preventDefault();
        if (e.target.classList.contains('bid')){
          const id = e.target.attributes.id.value;
          let price = e.target.previousElementSibling.value;
          const bidFormData = new FormData();
          bidFormData.append('submit_bid', true);
          bidFormData.append('property_id', id);
          bidFormData.append('price', price);
  
          fetch('./api.php', {
            method: 'post',
            body: bidFormData
          })
          .then(res=> res.json())
          .then(data=>{
            if (data.success) {
              showSnackbar("Bid added successfully")
            }
            if (data.error) throw new Error(data.error);
          })
          .catch(err=>  showSnackbar(err));
        }
        if(e.target.classList.contains("expand-image")) {
          console.log(e.target);
          let element = e.target.parentElement;
          let expandDetails = e.target.parentElement.parentElement.nextElementSibling;
          console.log(expandDetails);
          expandDetails.style.display = "block";
          element.style.display = "none";
        }
      })
    }

    const searchBidForm = document.querySelector('.search-bid-form');
    if (searchBidForm) {
      searchBidForm.addEventListener('submit', (e)=>{
        e.preventDefault();
        const searchFormData = new FormData(e.target);
        fetch('./api.php', {
          method:'post',
          body: searchFormData
        })
        .then((res)=>res.json())
        .then(data=>{
          const bidsTable = document.querySelector('#bids-table');
          bidsTable.innerHTML=`
          <tr>
            <th>Username</th>
            <th>Title</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          `;
          data.forEach(bid=>{
            bidsTable.insertAdjacentHTML('beforeend', bidsMarkup(bid));
          })
        })
        .catch(err=>console.log(err));
      })
    }

    const newsList = document.querySelector('.news-list');
    if(newsList) {
      const newFormData = new FormData();
      newFormData.append('get_news', true);
      fetch('./api.php', {
        method:"post",
        body: newFormData
      })
      .then(res=>res.json())
      .then(data=>{
        data.forEach(list=>{
          newsList.insertAdjacentHTML('beforeend', newsListMarkup(list));
        })
      })
      .catch(err=>console.log(err));
    }

    const propsTable = document.querySelector('#props-table');
    if (propsTable) {
      const propSelect = document.querySelector('#prop-select');
      const propsFormData = new FormData();
      propsFormData.append('get_props', true);
      propsTable.innerHTML = 
      `
      <tr>
        <th style="width:70%">Title</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      `;
      showPreloader(propsTable);
      fetch('./api.php', {
        method: 'post',
        body: propsFormData
      })
      .then(res=>res.json())
      .then(data=>{
        data.forEach(prop=>{
          propSelect.insertAdjacentHTML('beforeend', propListMarkup(prop));
          propsTable.insertAdjacentHTML('beforeend', propertiesMarkup(prop));
          propsTable.addEventListener('click', (e)=>{
            let element = e.target;
            if (element.classList.contains('remove')) {
              const formData = new FormData();
              formData.append('delete_property', true);
              formData.append('property_id', element.attributes.id.value);
              fetch('./api.php',{
                method:"post",
                body:formData
              })
              .then(res=>res.json())
              .then(data=>{
                console.log(data);
                window.location.reload();
              })
              .catch(err=>showSnackbar("Unable to Delete property"));
            }
          })
        })
      })
      .catch(err=>console.log(err))
      .finally(req=>clearPreloader(propsTable));
    }

    const bidsTable = document.querySelector("#bids-table");
    if (bidsTable) {
      bidsTable.addEventListener('click', (e)=>{
        let element = e.target;
        let parent = element.parentElement;
        let status = element.dataset.target;
        let bid_id = parent.attributes.id.value;
        let user_id = parent.dataset.user;
        console.log(user_id);
        if (element.classList.contains("bid-button")) {
          const formData = new FormData();
          formData.append("update_bid", true)
          formData.append("status", status);
          formData.append("bid_id", bid_id );
          formData.append("user_id", user_id);
          fetch('./api.php', {
            method:"post",
            body:formData
          })
          .then(res=>res.json())
          .then(data=>{
            if (data.error) throw new Error(data.error);
            parent.innerHTML = bidCondition(data.status);
            parent.previousElementSibling.innerHTML = data.status;
          })
          .catch(err=>{
            showSnackbar("Unable to update bid status")
          })
        }
      })
    }

    const bidsApprovalTable = document.querySelector("#bids-approval-table");
    if(bidsApprovalTable) {
      const formData = new FormData();
      formData.append('get_accepted_bids', true);
      fetch('./api.php', {
        method:"post",
        body: formData
      })
      .then(res=>res.json())
      .then(data=>{
        console.log(data);
        data.forEach(bid=>{
          bidsApprovalTable.insertAdjacentHTML('beforeend', acceptedBidsMarkup(bid));
        })
        bidsApprovalTable.addEventListener('click', (e)=>{
        let element = e.target;
        let parent = element.parentElement;
        let bid_id = parent.attributes.id.value;
        if (element.classList.contains("approve-button")) {
          const formData = new FormData();
          formData.append("approve_bids", true)
          formData.append("bid_id", bid_id );
          fetch('./api.php', {
            method:"post",
            body:formData
          })
          .then(res=>res.json())
          .then(data=>{
            if (data.error) throw new Error(data.error);
            window.location.reload();
          })
          .catch(err=>{
            showSnackbar("Unable to update bid status")
          })
        }
        })
      })
      .catch(err=>console.log(err));
    }
    
});

//Adds a preloader to the beginning of the element passed in as a parameter
function showPreloader(element){
  const markup =`
  <div id="loader">
  </div>
  `;
  element.insertAdjacentHTML('beforeend', markup);
}

//Clears Preloader from the element passed in as a parameter
function clearPreloader(element){
  const loader = element.querySelector('#loader');
  element.removeChild(loader);
}

function showSnackbar  (text) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");

    x.innerText = text;

    // Add the "show" class to DIV
    x.className = "show";
  
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}


const propsMarkup = (data) => {
  const markup = 
  `<div class="property-card">
    <div class="property-image">
        <img src="${data.image_path}" alt="">
    </div>
    <div class="property-details">
        <h3>${data.title}<span class="expand"><img class="expand-image" src="./assets/icons/expand.svg" /></span></h3>
        <div class="expand-details">
          <span class="property-details-title">city: </span> <span class="property-details-value">${data.city}</span><br/>
          <span class="property-details-title">state: </span> <span class="property-details-value">${data.state}</span><br/>
          <span class="property-details-title">address: </span> <span class="property-details-value">${data.address}</span><br/>
          <span class="property-details-title">market price: </span><span class="property-details-value">${data.market_price}</span><br/>
          <span class="property-details-title">No of Rooms: </span><span class="property-details-value">${data.total_room}</span><br/>
          <span class="property-details-title">Furnished: </span><span class="property-details-value">${data.furnished}</span><br/>
          <span class="property-details-title">Total Area: </span><span class="property-details-value">${data.total_area}</span><br/>      
        </div>
    </div>
    <form class="place-bid" >
        <div class="property-buttons">
            <input type="number" name="amount" value='${data.market_price}' step="500000" ">
            <button class="bid" id="${data.property_id}">Place Bid</button>
        </div>
    </form>
  </div>`
  return markup;
}

const userMarkup = (data) => {
  return `
  <tr id='${data.user_id}'>
    <td><a href="?view=singleuser#${data.user_id}">${data.username}</a></td>
    <td>${data.role}</td>
    <td>${data.status}</td>
    <td>${data.status == 'active' ? "<button class='deactivate change table-button'>Deactivate</button>":"<button class='activate change table-button'>activate</button>"}</td>
  </tr>
  `;
}

const newsMarkup = (data) => {
  return `
  <tr>
    <td>${data.title}</td>
    <td><button class='delete table-button' id="${data.news_id}">Delete</button></td>
  </tr>
  `
}

const bidsMarkup = (data) =>{
  return `
  <tr>
    <td style="width:25%"><a href="?view=singleuser#${data.user_id}" "target="_blank">${data.username}</a></td>
    <td style="width:55%"><a href="?view=singleproperty#${data.property_id}" "target="_blank">${data.title}</a></td>
    <td>${data.status}</td>
    <td id="${data.bid_id}" data-user=${data.user_id}>
      ${bidCondition(data.status)}
    </td>
  </tr>
  `
}

const bidCondition = data => {
  if(data === "pending"){
    return `<button class="table-button bid-button accept" data-target="accepted">Accept</button>
            <button class="table-button bid-button reject" data-target="rejected">Decline</button>`
  }
  else if(data === "accepted") {
    return `<button class="table-button bid-button reject" data-target="rejected">Decline</button>`;
  }
  else if(data === "rejected") {
    return `<button class="table-button bid-button accept" data-target="accepted">Accept</button>`;
  }
  else if(data=== "approved" || data ==="confirmed") {
    return ``;
  }
}

const newsListMarkup = (data) => {
  return `
  <li>${data.title}</li>
  `
}

const propertiesMarkup = (data) => {
  return `
  <tr>
    <td style="width:70%"><a href="?view=singleproperty#${data.property_id} "target="_blank"> ${data.title}</td>
    <td>${data.status}</td>
    <td><button class="table-button remove" id="${data.property_id}">Remove</button></td>
  </tr>
  `
}

const propListMarkup = data => {
  return `
  <option value="${data.property_id}" >${data.title}</option>
  `
}

const fullScreenLoader = () => {
  const loader = document.querySelector("#full-loader");
  loader.style.display="flex";
}

const exitScreenLaoder = () => {
  const loader = document.querySelector("#full-loader");
  loader.style.display="none";
}

const acceptedBidsMarkup = (data) => {
  return `
  <tr>
    <td><a href="?view=singleuser#${data.agent_id}" target="_blank">${data.agent_id}</a></td>
    <td><a href="?view=singleuser#${data.user_id}" target="_blank">${data.user_id}</a></td>
    <td><a href="?view=singleproperty#${data.property_id}" target="_blank">${data.property_id}</a></td>
    <td>${data.market_price}</td>
    <td>${data.bid_price}</td>
    <td id="${data.bid_id}" data-user=${data.user_id}><button class="table-button approve-button accept">Approve</button></td>
  </tr>
  `
}