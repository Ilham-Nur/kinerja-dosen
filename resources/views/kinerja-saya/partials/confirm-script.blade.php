<script>
document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('form[data-confirm="true"]').forEach((form)=>{
    form.addEventListener('submit', async (event)=>{
      event.preventDefault();
      const type = form.dataset.confirmType || 'warning';
      const ok = await ConfirmDialog.show({
        title: form.dataset.confirmTitle || 'Konfirmasi',
        body: form.dataset.confirmBody || 'Apakah Anda yakin ingin melanjutkan?',
        type,
        confirmText: 'Ya, Lanjut',
        cancelText: 'Batal',
        confirmClass: type === 'danger' ? 'btn-danger' : 'btn-primary'
      });
      if (ok) form.submit();
    });
  });
});
</script>
