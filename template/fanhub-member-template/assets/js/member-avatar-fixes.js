(function(){let profileLoaded=false;
  const setAvatar=url=>{if(!url)return;const avatar=document.querySelector('#memberAvatar');if(avatar)avatar.innerHTML=`<img src="${url}" alt="">`};
  const csrf=async()=>{const r=await fetch('/user/api/auth/csrf',{credentials:'same-origin'});return (await r.json()).csrf_token};
  async function enhance(){
    const form=document.querySelector('#memberProfileForm');
    if(form&&!document.querySelector('#memberAvatarForm')){
      const block=document.createElement('div');block.className='member-avatar-upload';block.innerHTML='<img id="memberAvatarPreview" alt="Profile picture"><form id="memberAvatarForm"><label>Profile picture<input type="file" name="file" accept="image/png,image/jpeg,image/webp,image/gif" required></label><button class="member-primary" type="submit">Upload picture</button></form></div>';form.prepend(block);
      document.querySelector('#memberAvatarForm').onsubmit=async event=>{event.preventDefault();try{const response=await fetch('/user/api/profile/avatar',{method:'POST',credentials:'same-origin',headers:{'X-CSRF-TOKEN':await csrf(),Accept:'application/json'},body:new FormData(event.currentTarget)});if(!response.ok)throw Error('Avatar upload failed');const result=await response.json();setAvatar(result.data.avatar_url);document.querySelector('#memberAvatarPreview').src=result.data.avatar_url;toast('Profile picture updated')}catch(error){toast(error.message)}};
    }
    if(!profileLoaded)try{const response=await fetch('/user/api/auth/me',{credentials:'same-origin',headers:{Accept:'application/json'}});if(response.ok){const result=await response.json();const url=result.data?.profile?.avatar_url;setAvatar(url);const preview=document.querySelector('#memberAvatarPreview');if(preview&&url)preview.src=url;profileLoaded=true}}catch(error){}
  }
  const observer=new MutationObserver(enhance);observer.observe(document.body,{childList:true,subtree:true});enhance();setInterval(enhance,10000);
})();
