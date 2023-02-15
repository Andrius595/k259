function Header({ text }: { text: string }): JSX.Element {
  return (
    <div className="headerInfo">
      <p className="notice">
        Welcome to TrashTracker
        <br />
        <br />
        The easiest way to report and organize clean-up events in your
        community!
        <br />
        <br />
        <i>{text}</i>
      </p>
    </div>
  );
}

export default Header;
