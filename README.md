# GCC TV Wordwall App

An interactive and engaging Wordwall-style game application designed for GCC TV. Create, manage, and play educational games such as quizzes and matching pairs, with full localization and leaderboard support.

## ✨ Features

- **Game Management**: Easily create, edit, and manage games and questions.
- **Multiple Game Templates**: Switch between "Match Up", "Quiz", and more templates instantly.
- **Leaderboard**: Track high scores and student progress to foster competition.
- **Localization**: Full support for English and Arabic, including RTL layout.
- **Responsive Design & Themes**: Modern UI, theme selection, and seamless experience on any device.
- **User Feedback**: Integrated notification system for actions and errors.

## 🚀 Tech Stack

- **Frontend**: Astro, TypeScript, Vanilla JS
- **Backend**: PHP (SQLite) for local dev, [Supabase](https://supabase.io/) for production (Postgres, Auth, APIs)
- **Styling**: Tailwind CSS, custom CSS variables

## ⚙️ Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

You need [Node.js](https://nodejs.org/en/) (v18 or newer) and `npm`, `pnpm`, or `yarn` installed on your system.

### Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/aldoyh/gcc-tv-wordwall-app.git
    cd gcc-tv-wordwall-app
    ```

2.  **Install dependencies**

    ```bash
    pnpm install
    ```

3.  **Set up environment variables**

    Create a `.env` file by copying the example file:

    ```bash
    cp .env-example .env
    ```

    Now, open the `.env` file and add your project-specific Supabase URL and Anon Key. You can find these in your Supabase project's API settings.

4.  **Run the development server**

    ```bash
    pnpm run dev
    ```

    Open http://localhost:5173 (or your framework's default port) to view it in the browser.

## 📜 Available Scripts

- `pnpm run dev`: Starts the development server.
- `pnpm run build`: Builds the app for production.
- `pnpm run lint`: Lints the codebase for errors.
- `pnpm run format`: Formats all files with Prettier.

## 🔒 Security Note

This project uses Supabase's Row Level Security (RLS). Ensure RLS is enabled on all tables containing sensitive data to prevent unauthorized access.

---
For full usage instructions and feature details, see `Docs/USAGE.md` and `Docs/WordWall_Features.md`.