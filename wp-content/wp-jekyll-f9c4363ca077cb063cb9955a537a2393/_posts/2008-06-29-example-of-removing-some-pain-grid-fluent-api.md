---
id: 66
title: 'Example of Removing Some Pain: Grid Fluent API'
date: 2008-06-29T03:37:31+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/28/example-of-removing-some-pain-grid-fluent-api.aspx
permalink: /2008/06/29/example-of-removing-some-pain-grid-fluent-api/
dsq_thread_id:
  - "262113968"
categories:
  - .NET
  - Fluent API
---
So on a previous project, we were making use a 3rd party WinForms UberGrid which, of course has a monstrous designer that spits out tons of code into your InitializeComponent() method in your .designer file. I think you know what I&#8217;m talking about, but for those who wish to experience it in all its glory, check out this:

<div class="csharpcode-wrapper" style="overflow: auto;height: 200px">
  <pre>Infragistics.Win.Appearance appearance4 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance1 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance2 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance3 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance7 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance6 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance5 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance9 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance11 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance10 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
Infragistics.Win.Appearance appearance8 = <span class="kwrd">new</span> Infragistics.Win.Appearance();
<span class="kwrd">this</span>._lineItemsGrid = <span class="kwrd">new</span> Infragistics.Win.UltraWinGrid.UltraGrid();
((System.ComponentModel.ISupportInitialize)(<span class="kwrd">this</span>._lineItemsGrid)).BeginInit();
<span class="kwrd">this</span>.SuspendLayout();
<span class="rem">// </span>
<span class="rem">// _lineItemsGrid</span>
<span class="rem">// </span>
appearance4.BackColor = System.Drawing.SystemColors.Window;
appearance4.BorderColor = System.Drawing.SystemColors.InactiveCaption;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Appearance = appearance4;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.AutoFitStyle = Infragistics.Win.UltraWinGrid.AutoFitStyle.None;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.BorderStyle = Infragistics.Win.UIElementBorderStyle.Solid;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.CaptionVisible = Infragistics.Win.DefaultableBoolean.False;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.EmptyRowSettings.ShowEmptyRows = <span class="kwrd">true</span>;
appearance1.BackColor = System.Drawing.SystemColors.ActiveBorder;
appearance1.BackColor2 = System.Drawing.SystemColors.ControlDark;
appearance1.BackGradientStyle = Infragistics.Win.GradientStyle.Vertical;
appearance1.BorderColor = System.Drawing.SystemColors.Window;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.GroupByBox.Appearance = appearance1;
appearance2.ForeColor = System.Drawing.SystemColors.GrayText;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.GroupByBox.BandLabelAppearance = appearance2;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.GroupByBox.BorderStyle = Infragistics.Win.UIElementBorderStyle.Solid;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.GroupByBox.Hidden = <span class="kwrd">true</span>;
appearance3.BackColor = System.Drawing.SystemColors.ControlLightLight;
appearance3.BackColor2 = System.Drawing.SystemColors.Control;
appearance3.BackGradientStyle = Infragistics.Win.GradientStyle.Horizontal;
appearance3.ForeColor = System.Drawing.SystemColors.GrayText;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.GroupByBox.PromptAppearance = appearance3;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.MaxColScrollRegions = 1;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.MaxRowScrollRegions = 1;
appearance7.BackColor = System.Drawing.SystemColors.Highlight;
appearance7.ForeColor = System.Drawing.SystemColors.HighlightText;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.ActiveRowAppearance = appearance7;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowAddNew = Infragistics.Win.UltraWinGrid.AllowAddNew.No;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowColMoving = Infragistics.Win.UltraWinGrid.AllowColMoving.NotAllowed;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowColSizing = Infragistics.Win.UltraWinGrid.AllowColSizing.Free;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowColSwapping = Infragistics.Win.UltraWinGrid.AllowColSwapping.NotAllowed;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowDelete = Infragistics.Win.DefaultableBoolean.False;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowRowFiltering = Infragistics.Win.DefaultableBoolean.False;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowRowSummaries = Infragistics.Win.UltraWinGrid.AllowRowSummaries.False;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.AllowUpdate = Infragistics.Win.DefaultableBoolean.False;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.BorderStyleCell = Infragistics.Win.UIElementBorderStyle.Dotted;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.BorderStyleRow = Infragistics.Win.UIElementBorderStyle.Dotted;
appearance6.BackColor = System.Drawing.SystemColors.Window;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.CardAreaAppearance = appearance6;
appearance5.BorderColor = System.Drawing.Color.Silver;
appearance5.FontData.Name = <span class="str">"QuickType Mono"</span>;
appearance5.FontData.SizeInPoints = 10F;
appearance5.TextTrimming = Infragistics.Win.TextTrimming.EllipsisCharacter;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.CellAppearance = appearance5;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.CellClickAction = Infragistics.Win.UltraWinGrid.CellClickAction.RowSelect;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.CellPadding = 0;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.ColumnSizingArea = Infragistics.Win.UltraWinGrid.ColumnSizingArea.EntireColumn;
appearance9.BackColor = System.Drawing.SystemColors.Control;
appearance9.BackColor2 = System.Drawing.SystemColors.ControlDark;
appearance9.BackGradientAlignment = Infragistics.Win.GradientAlignment.Element;
appearance9.BackGradientStyle = Infragistics.Win.GradientStyle.Horizontal;
appearance9.BorderColor = System.Drawing.SystemColors.Window;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.GroupByRowAppearance = appearance9;
appearance11.TextHAlignAsString = <span class="str">"Left"</span>;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.HeaderAppearance = appearance11;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.HeaderStyle = Infragistics.Win.HeaderStyle.WindowsXPCommand;
appearance10.BackColor = System.Drawing.SystemColors.Window;
appearance10.BorderColor = System.Drawing.Color.Silver;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.RowAppearance = appearance10;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.RowSelectorHeaderStyle = Infragistics.Win.UltraWinGrid.RowSelectorHeaderStyle.SeparateElement;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.RowSelectors = Infragistics.Win.DefaultableBoolean.True;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.RowSizing = Infragistics.Win.UltraWinGrid.RowSizing.Fixed;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.SelectTypeCell = Infragistics.Win.UltraWinGrid.SelectType.None;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.SelectTypeCol = Infragistics.Win.UltraWinGrid.SelectType.None;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.SelectTypeRow = Infragistics.Win.UltraWinGrid.SelectType.Single;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.SummaryDisplayArea = Infragistics.Win.UltraWinGrid.SummaryDisplayAreas.None;
appearance8.BackColor = System.Drawing.SystemColors.ControlLight;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.Override.TemplateAddRowAppearance = appearance8;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.ScrollBounds = Infragistics.Win.UltraWinGrid.ScrollBounds.ScrollToFill;
<span class="kwrd">this</span>._lineItemsGrid.DisplayLayout.ScrollStyle = Infragistics.Win.UltraWinGrid.ScrollStyle.Immediate;
<span class="kwrd">this</span>._lineItemsGrid.Dock = System.Windows.Forms.DockStyle.Top;
<span class="kwrd">this</span>._lineItemsGrid.Location = <span class="kwrd">new</span> System.Drawing.Point(0, 0);
<span class="kwrd">this</span>._lineItemsGrid.Name = <span class="str">"_lineItemsGrid"</span>;
<span class="kwrd">this</span>._lineItemsGrid.Size = <span class="kwrd">new</span> System.Drawing.Size(908, 226);
<span class="kwrd">this</span>._lineItemsGrid.TabIndex = 0;
<span class="kwrd">this</span>._lineItemsGrid.Text = <span class="str">"_lineItemsGrid"</span>;</pre>
</div>

Rather than having to deal with all that code and all the potential for inconsistencies in style, behavior, etc in all the various screens in which grids would appear, we decided to wrap the bulk of the building of appearances into a fluent API that ended up looking something like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">new</span> GridLayout(_lineItemsGrid)
    .AutoFitColumns()
    .EditingDisabled()
    .AddColumn(<span class="str">"Id"</span>).ThatIsHidden()
    .AddColumn(<span class="str">"Description"</span>).WithWidth(225)
    .AddColumn(<span class="str">"Quantity"</span>).WithWidth(40).FormatValueAs(<span class="str">"F4"</span>).AlignRight()
    .AddColumn(<span class="str">"Size"</span>).WithWidth(50).AlignRight().FormatValueAs("F4")
    .AddColumn(<span class="str">"Price"</span>).WithWidth(50).AlignRight().FormatValueAs(<span class="str">"C4"</span>)
    .OnRowSelected((values) =&gt; _model.ViewItem(values[<span class="str">"Id"</span>]))
    .OnRowDoubleClick((values) =&gt; _model.EditItem(values[<span class="str">"Id"</span>]));</pre>
</div>

Now, when a feature came in for us to change certain styles or behavior of all the grids (i.e. make the headers look like THIS) we changed it in one place and it affected everything.

We considered using a grid-wrapping UserControl for this type of reuse and behavior, but it turns out that about half of the code was common among all grids and half was specific to each form. So we would&#8217;ve had to build a kitchen-sink type UserControl that ultimately would&#8217;ve taken us down the path of exposing much of the raw grid API to each form which was not as desirable.

Other benefits we gained by this approach:

  1. Testing was much easier because the GridLayout builder could embed certain controls and special tags on controls in order to highlight things for StoryTeller/Fit testing.&nbsp; Also, we could test that certain conventions were being followed by all the forms rather than having each form build its own grid and having to test that it did it correctly, we could just test/enforce that the GridLayout builder worked properly.
  2. When we started making the switch to WPF, we were able to switch to a WPF grid control with only a one-line change to each view (to change the type declaration of _lineItemsGrid).
  3. Easier integration with various services like user permissions (i.e. certain users can never see the &#8216;Margin&#8217; column in any grid)

### Building a Fluent Interface To Drive Settings On Another Object

Building a fluent interface like this was pretty easy: just make each call return the instance of GridLayout!&nbsp; 

Here&#8217;s an example method:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> GridLayout AutoFitColumns()
{
    _grid.DisplayLayout.AutoFitStyle = AutoFitStyle.ResizeAllColumns;
    <span class="kwrd">return</span> <span class="kwrd">this</span>;
}</pre>
</div>

Building up the columns required that I remember the last column that was added so I can keep context. 

For example:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> GridLayout AddColumn(<span class="kwrd">string</span> key)
{
    _lastColumn = _grid.DisplayLayout.Bands[0].Columns.Add(key);
    <span class="kwrd">return</span> <span class="kwrd">this</span>;
}

<span class="kwrd">public</span> GridLayout ThatIsHidden()
{
    _lastColumn.Hidden = <span class="kwrd">true</span>;
    <span class="kwrd">return</span> <span class="kwrd">this</span>;
}

<span class="kwrd">public</span> GridLayout Header(<span class="kwrd">string</span> header)
{
    _lastColumn.Header.Caption = header;
    <span class="kwrd">return</span> <span class="kwrd">this</span>;
}</pre>
</div>