// assets/bootstrap.js

import { Application } from '@hotwired/stimulus';

const application = Application.start();

// Optional: auto-register controllers
import { registerControllers } from '@symfony/stimulus-bridge';
registerControllers(application, require.context('./controllers', true, /\.js$/));

export { application };