interface NotificationOptions {
  message: string;
  type?: 'success' | 'error' | 'info';
  duration?: number;
}

export function showNotification({ message, type = 'info', duration = 3000 }: NotificationOptions) {
  const container = document.getElementById('notification-container');
  if (!container) return;

  const notification = document.createElement('div');
  notification.className = `p-3 mb-3 rounded-md shadow-md text-white transform transition-transform ease-out duration-300 translate-x-full opacity-0`;

  switch (type) {
    case 'success':
      notification.classList.add('bg-green-500');
      break;
    case 'error':
      notification.classList.add('bg-red-500');
      break;
    case 'info':
      notification.classList.add('bg-blue-500');
      break;
  }

  notification.textContent = message;
  container.appendChild(notification);

  // Animate in
  setTimeout(() => {
    notification.classList.remove('translate-x-full', 'opacity-0');
    notification.classList.add('translate-x-0', 'opacity-100');
  }, 10);

  // Animate out and remove
  setTimeout(() => {
    notification.classList.remove('translate-x-0', 'opacity-100');
    notification.classList.add('translate-x-full', 'opacity-0');
    notification.addEventListener('transitionend', () => {
      notification.remove();
    });
  }, duration);
}
