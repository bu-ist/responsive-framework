/**
 * The entry point for theme scripts.
 *
 * Modules are imported and compiled into one resulting `theme.js` file.
 *
 * @package ResponsiveFramework
 */

// Import Foundation scripts.
import toggle from 'responsive-foundation';

// This isn't working. And neither is `toggle()`.
console.log( toggle );

// This would work, but would automatically execute the underlying js.
//import 'responsive-foundation';
