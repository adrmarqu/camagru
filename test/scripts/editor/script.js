import Camera from './camera/camera.js';
import Events from './core/events.js';
import States from './core/states.js';
import Capture from './camera/capture.js';

Camera.init();
States.init();
Capture.init();
Events.prepare();