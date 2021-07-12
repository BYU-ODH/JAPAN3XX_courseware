#if !defined(AFX_JUMPTO_H__2BBC4FD0_01D0_4BAA_AF00_72687F9FD369__INCLUDED_)
#define AFX_JUMPTO_H__2BBC4FD0_01D0_4BAA_AF00_72687F9FD369__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000
// JumpTo.h : header file
//

/////////////////////////////////////////////////////////////////////////////
// JumpTo dialog

class JumpTo : public CDialog
{
// Construction
public:
	JumpTo(CWnd* pParent = NULL);   // standard constructor

// Dialog Data
	//{{AFX_DATA(JumpTo)
	enum { IDD = IDR_MAINFRAME };
	int		m_Jump;
	//}}AFX_DATA


// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(JumpTo)
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	//}}AFX_VIRTUAL

// Implementation
protected:

	// Generated message map functions
	//{{AFX_MSG(JumpTo)
	afx_msg void OnSelchangeJump();
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_JUMPTO_H__2BBC4FD0_01D0_4BAA_AF00_72687F9FD369__INCLUDED_)
